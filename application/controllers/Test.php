<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('test');
	}

    public function count_lev_dist(){
		$query = $this->db->get('dataset_skripsi');
		$data = $query->result();

		$target_lang = $this->input->get("target_lang", TRUE);

		$response = null;
		
		if($target_lang == "indonesia"){
			$response = array_map(function($item){
				return [
					'no' => $item->no,
					'lev_dist' => levenshtein(strtolower($this->input->get("word_query", TRUE)), $item->bahasa_manado),
					'compared_word' => strtolower($item->bahasa_manado)
				];
			}, $data);
		}else if($target_lang == "manado"){
			$response = array_map(function($item){
				return [
					'no' => $item->no,
					'lev_dist' => levenshtein(strtolower($this->input->get("word_query", TRUE)), $item->bahasa_indonesia),
					'compared_word' => strtolower($item->bahasa_indonesia)
				];
			}, $data);
		}

		sort($response, SORT_NUMERIC);

        // echo implode("<br/>", $response);
		echo json_encode($response);
    }

	public function get_translated_word(){
		$word_query = $this->input->get("word_query", TRUE);
		$from_lang = $this->input->get("from_lang", TRUE);
		$no = $this->input->get("no", TRUE);

		$this->db->where("bahasa_$from_lang", strtolower($word_query));
		$this->db->where("no", $no);
		$query = $this->db->get('dataset_skripsi');
		$result = $query->result();

		if($from_lang == "indonesia"){
			echo strtolower($result[0]->bahasa_manado);
		}else if($from_lang == "manado"){
			echo strtolower($result[0]->bahasa_indonesia);
		} 
	}

	public function count_raita(){

		/*
			-- OPTIMIZED --
			1. skip when pattern longer than text
			2. break when count raita time longer then 0.001 ms to avoid program crash
		*/
		$query = $this->db->get('dataset_skripsi');
		$data = $query->result();
		$from_lang = $this->input->get("from_lang", TRUE);
		$pattern = strtolower($this->input->get("word_query", TRUE));
		$bmbc = $this->generate_table_bmbc($pattern);

		$response = array();

		foreach($data as $row){
			$text = null;
			$no = $row->no;
			if($from_lang == "indonesia"){
				$text = strtolower($row->bahasa_indonesia);
			}else if($from_lang == "manado"){
				$text = strtolower($row->bahasa_manado);
			}

			// skip when pattern length longer then text
			if(strlen($pattern) > strlen($text)){
				continue;
			}

			// initialiation raita
			$iteration = 1;
			$fit = 0;
			$move = 0;
			$pos = strlen($pattern) - 1;
			$pos_text = $pos;

			$time_start = microtime(TRUE);
			// echo "tahap iterasi-$iteration : <br>";
			while($pos_text <= strlen($text) - 1){
				if($text[$pos_text] == $pattern[$pos]){
					// echo "$text[$pos_text]-$pattern[$pos], pos_text:$pos_text, pos:$pos <br>";
					$pos -= 1;
					$pos_text -= 1;
					$fit += 1;

				}

				if($fit == strlen($pattern)){
					// echo "ketemu di iterasi-ke $iteration";
					array_push($response, [
						"no" => $no,
						"word" => $text,
						"iteration" => $iteration
					]);
					break;
				}

				if($text[$pos_text] != $pattern[$pos]){
					$isFound = false;
					foreach($bmbc as $row){
						if($text[$pos_text] == $row["char"]){
							$move += $row["score"];
							$isFound = true;
							break;
						}
					}
					if($isFound == false){
						$move += strlen($pattern);
					}
					// echo $text[$pos_text]."-".$pattern[$pos].", pos_text=$pos_text, geser=".$move.", pos = $pos<br><br>";
					$pos_text += $move;

					# reset variable
					$pos = strlen($pattern) - 1;
					$move = 0;
					$fit = 0;

					# increase iteration
					$iteration += 1;
					// echo "tahap iterasi-$iteration : <br>";
				}			
				$time_end = microtime(TRUE);
				$execution_time = ($time_end - $time_start)/60;
				// echo $execution_time."<br>";
				if($execution_time > 0.001){
					$time_start = microtime(TRUE);
					break;
				}

			}
		}

		

		if(count($response) != 0){
			echo json_encode([
				'status' => true,
				'data' => $response
			]);
		}else{
			echo json_encode([
				'status' => false ,
				'message' => "kata tidak ditemukan"
			]);
		}
	}

	public function generate_table_bmbc($pattern){
		$bmbc = array();

		for($i=0;$i<strlen($pattern);$i++){
			if($i == strlen($pattern) - 1){
				array_push($bmbc, ["char" => "*", "score" => strlen($pattern)]);
			}else{
				array_push($bmbc, ["char" => $pattern[$i], "score" => strlen($pattern) - $i - 1]);
			}
		}

		return $bmbc;

	}


	public function confusion_matrix(){
		// $actual = array("mobil", "jalan", "rumah");
		// $predicted = array("motor", "jalan", "rumah");
		$query = $this->db->get('dataset_skripsi');
		$data = $query->result();

		$query = $this->db->get('coba_akurasi');
		$data_input = $query->result();

		$input = array_map(function($item){
					return strtolower($item->bahasa_manado);
				}, $data_input);
		$actual = array_map(function($item){
					return strtolower($item->bahasa_indonesia);
				}, $data_input);

		// $input = array("sya", "kamu", "mal", "makn", "ikan");
		// // Ground truth data
		// $actual = array("kita", "ngana", "malo", "ceke", "ikang");


		function generate_table_bmbc($pattern){
			$bmbc = array();

			for($i=0;$i<strlen($pattern);$i++){
				if($i == strlen($pattern) - 1){
					array_push($bmbc, ["char" => "*", "score" => strlen($pattern)]);
				}else{
					array_push($bmbc, ["char" => $pattern[$i], "score" => strlen($pattern) - $i - 1]);
				}
			}

			return $bmbc;

		}


		function sortByRaitaIter($item1, $item2){
			 //If the prices are same return 0.
			 if($item1["iteration"] == $item2["iteration"]) return 0;
			 //If price of $item1 < $item2 then return -1 else return 1.
			 return $item1['iteration'] < $item2['iteration'] ? -1 : 1;
		}

		// COUNT RAITA
		function count_raita($data, $pattern, $from_lang){
			$bmbc = generate_table_bmbc($pattern);

			$response = array();

			foreach($data as $row){
				$text = null;
				$no = $row->no;
				if($from_lang == "indonesia"){
					$text = strtolower($row->bahasa_indonesia);
					$translated_word = strtolower($row->bahasa_manado);
				}else if($from_lang == "manado"){
					$text = strtolower($row->bahasa_manado);
					$translated_word = strtolower($row->bahasa_indonesia);
				}

				// skip when pattern length longer then text
				if(strlen($pattern) > strlen($text)){
					continue;
				}

				// initialiation raita
				$iteration = 1;
				$fit = 0;
				$move = 0;
				$pos = strlen($pattern) - 1;
				$pos_text = $pos;

				$time_start = microtime(TRUE);
				// echo "tahap iterasi-$iteration : <br>";
				while($pos_text <= strlen($text) - 1){
					if($text[$pos_text] == $pattern[$pos]){
						// echo "$text[$pos_text]-$pattern[$pos], pos_text:$pos_text, pos:$pos <br>";
						$pos -= 1;
						$pos_text -= 1;
						$fit += 1;

					}

					if($fit == strlen($pattern)){
						// echo "ketemu di iterasi-ke $iteration";
						array_push($response, [
							"no" => $no,
							"word" => $text,
							"translated_word" => $translated_word,
							"iteration" => $iteration
						]);
						break;
					}

					if($text[$pos_text] != $pattern[$pos]){
						$isFound = false;
						foreach($bmbc as $row){
							if($text[$pos_text] == $row["char"]){
								$move += $row["score"];
								$isFound = true;
								break;
							}
						}
						if($isFound == false){
							$move += strlen($pattern);
						}
						// echo $text[$pos_text]."-".$pattern[$pos].", pos_text=$pos_text, geser=".$move.", pos = $pos<br><br>";
						$pos_text += $move;

						# reset variable
						$pos = strlen($pattern) - 1;
						$move = 0;
						$fit = 0;

						# increase iteration
						$iteration += 1;
						// echo "tahap iterasi-$iteration : <br>";
					}			
					$time_end = microtime(TRUE);
					$execution_time = ($time_end - $time_start)/60;
					// echo $execution_time."<br>";
					if($execution_time > 0.001){
						$time_start = microtime(TRUE);
						break;
					}

				}
			}
			return $response;
		}


		// COUNT LEV DIST
		function count_lev_dist($data, $word_query, $target_lang){
			$response = null;
			
			if($target_lang == "indonesia"){
				$response = array_map(function($item) use ($word_query){
					return [
						'no' => $item->no,
						'lev_dist' => levenshtein(strtolower($word_query), $item->bahasa_manado),
						'compared_word' => strtolower($item->bahasa_manado),
						'translated_word' => strtolower($item->bahasa_indonesia)
					];
				}, $data);
			}else if($target_lang == "manado"){
				$response = array_map(function($item) use ($word_query){
					return [
						'no' => $item->no,
						'lev_dist' => levenshtein(strtolower($word_query), $item->bahasa_indonesia),
						'compared_word' => strtolower($item->bahasa_indonesia),
						'translated_word' => strtolower($item->bahasa_manado)
					];
				}, $data);
			}

			sort($response, SORT_NUMERIC);

			return $response;
		}



		function sortByLevDist($item1, $item2){
			 //If the prices are same return 0.
			 if($item1["lev_dist"] == $item2["lev_dist"]) return 0;
			 //If price of $item1 < $item2 then return -1 else return 1.
			 return $item1['lev_dist'] < $item2['lev_dist'] ? -1 : 1;
		}

		foreach($input as $inp){
			echo "$inp, ";
		}
		echo "<br>";

		foreach($actual as $act){
			echo "$act, ";
		}

		echo "<br>";
		$tp = 0;
		$fp = 0;
		for($i=0; $i<count($actual); $i++){
			$from_lang = "manado";
			$target_lang = "indonesia";

			$counted_raita = count_raita($data, $word_query=$input[$i], $from_lang);

			if(count($counted_raita) != 0){
				usort($counted_raita, "sortByRaitaIter");
				$result_10 = array_slice($counted_raita, 0, 10);

				echo "<b>".$input[$i]."-".$actual[$i]."</b><br>";
				echo "$i. RAITA<br>";
				foreach($result_10 as $res){
					echo "word: ".$res['word']."<br>";
					$trans =  "translated_word: ".$res['translated_word']."<br>";
					if($res['translated_word'] == $actual[$i]){
						$trans =  "<b>translated_word: ".$res['translated_word']."</b><br>";
					}
					echo $trans;
					echo "-----------<br>";
				}

				$is_exist = current(array_filter($result_10, function($item) use($actual, $i){
					return $item['translated_word'] == $actual[$i];
				}));	
				if($is_exist != FALSE){
					$tp+=1;
				}else{
					$fp+=1;
				}
				continue;
			}

			// count using lev dist when raita not found
			$counted_lev_dist = count_lev_dist($data, $word_query=$input[$i], $target_lang);
			usort($counted_lev_dist, "sortByLevDist");
			$result_10 = array_slice($counted_lev_dist, 0, 10);
			
			echo "<b>".$input[$i]."-".$actual[$i]."</b><br>";
			echo "$i. LEVENSHTEIN<br>";
			foreach($result_10 as $res){
				echo "compared_word: ".$res['compared_word']."<br>";
				$trans =  "translated_word: ".$res['translated_word']."<br>";
				if($res['translated_word'] == $actual[$i]){
					$trans =  "<b>translated_word: ".$res['translated_word']."</b><br>";
				}
				echo $trans;
				echo "-----------<br>";
			}

			$is_exist = current(array_filter($result_10, function($item) use ($actual, $i){
				return $item['translated_word'] == $actual[$i];
			}));

			if($is_exist != FALSE){
				$tp+=1;
			}else{
				$fp+=1;
			}
		}
		echo "tp = $tp <br>";
		echo "fp = fn = $fp";
		$fn = $fp;
		$tn = 0;

		echo "<br>";
		$accuracy = ($tp + $tn) / ($tp + $tn + $fp + $fn) * 100;
		echo "accuracy = ($tp + $tn) / ($tp + $tn + $fp + $fn) <br>";
		echo "accuracy = $accuracy %";

		die();

		// Predicted data
		$predicted = array("book", "lamp", "chair", "desk", "door");

		// Initialize variables for TP, TN, FP, and FN
		$tp = 0;
		$tn = 0;
		$fp = 0;
		$fn = 0;

		// Loop through the data and calculate TP, TN, FP, and FN
		for ($i = 0; $i < count($actual); $i++) {
			if(strtolower($actual[$i]) == strtolower($predicted[$i])){
				$tp += 1;
			}else{
				$fp += 1;
				$fn += 1;
			}
		}

		// Print the values of TP, TN, FP, and FN
		for($i = 0; $i<count($actual); $i++){
			echo $actual[$i]. "-". $predicted[$i] ."<br>";
		}
		
		echo "TP: " . $tp . "<br>";
		echo "TN: " . $tn . "<br>";
		echo "FP: " . $fp . "<br>";
		echo "FN: " . $fn . "<br>";

		$accuracy = ($tp + $tn) / ($tp + $tn + $fp + $fn);
		echo "accuracy = ($tp + $tn) / ($tp + $tn + $fp + $fn) <br>";
		echo "accuracy = $accuracy";

	}

	public function confusion_matrix_table(){
		$sql = "SELECT * FROM confusion_matrix WHERE col_1 = 'nama'";
		$query = $this->db->query($sql);
		$result_header = $query->result_array()[0];

		
		$query = $this->db->get("confusion_matrix");

		$getReference = get_object_vars($query->result()[2]);
		$reference = [];
		$idx = 0; 
		foreach($getReference as $key){
			if($idx == 0){
				$idx += 1;
				continue;
			}else{
				array_push($reference, $key);
				$idx += 1;
			}
		}
		
		$scores = [];
		$idx = 0;
		foreach($reference as $key){
			array_push(
				$scores,
				[$key => 0]
			);
		}


		foreach($query->result() as $row){
			$row = get_object_vars($row);

			if(trim($row['col_1']) == 'nama'){
				continue;
			}
			$idx = 0;
			foreach($row as $value){
				if($idx == 0){
					$idx += 1;
					continue;
				}else{
					if($value == $reference[$idx-1]){
						$scores[$idx-1][$reference[$idx-1]] += 1;
					}
					$idx += 1;
				}
			}
		}

		return $this->load->view('confusion_matrix', [
			'header_table' => $result_header,
			'scores' => $scores,
			'reference' => $reference
		]);
	}
}
