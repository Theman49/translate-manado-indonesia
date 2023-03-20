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
					'lev_dist' => levenshtein(strtolower($this->input->get("word_query", TRUE)), $item->bahasa_manado),
					'compared_word' => strtolower($item->bahasa_manado)
				];
			}, $data);
		}else if($target_lang == "manado"){
			$response = array_map(function($item){
				return [
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

		$this->db->where("bahasa_$from_lang", strtolower($word_query));
		$query = $this->db->get('dataset_skripsi');
		$result = $query->result();

		if($from_lang == "indonesia"){
			echo strtolower($result[0]->bahasa_manado);
		}else if($from_lang == "manado"){
			echo strtolower($result[0]->bahasa_indonesia);
		} 
	}

	public function count_raita(){
		$query = $this->db->get('dataset_skripsi');
		$data = $query->result();
		$from_lang = $this->input->get("from_lang", TRUE);
		$pattern = strtolower($this->input->get("word_query", TRUE));
		$bmbc = $this->generate_table_bmbc($pattern);

		$response = array();

		foreach($data as $row){
			$text = null;
			if($from_lang == "indonesia"){
				$text = strtolower($row->bahasa_indonesia);
			}else if($from_lang == "manado"){
				$text = strtolower($row->bahasa_manado);
			}

			// initialiation raita
			$iteration = 1;
			$fit = 0;
			$move = 0;
			$pos = strlen($pattern) - 1;
			$pos_text = $pos;

			// echo "tahap iterasi-$iteration : <br>";
			while($pos_text <= strlen($text) - 1){
				if($text[$pos_text] == $pattern[$pos]){
					// echo "$text[$pos_text]-$pattern[$pos], pos_text:$pos_text, pos:$pos <br>";
					$pos -= 1;
					$pos_text -= 1;
					$fit += 1;

				}

				if($fit == strlen($pattern)){
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

			}
			if($fit == strlen($pattern)){
				// echo "ketemu di iterasi-ke $iteration";
				array_push($response, [
					"word" => $text,
					"iteration" => $iteration
				]);
			}
			
		}

		// $text = strtolower($this->input->get("text", TRUE));
		// $pattern = strtolower($this->input->get("pattern", TRUE));
		// $bmbc = $this->generate_table_bmbc($pattern);

		// // initialiation raita
		// $iteration = 1;
		// $fit = 0;
		// $move = 0;
		// $pos = strlen($pattern) - 1;
		// $pos_text = $pos;

		// echo "tahap iterasi-$iteration : <br>";
		// while($pos_text <= strlen($text) - 1){
		// 	if($text[$pos_text] == $pattern[$pos]){
		// 		echo "$text[$pos_text]-$pattern[$pos], pos_text:$pos_text, pos:$pos <br>";
		// 		$pos -= 1;
		// 		$pos_text -= 1;
		// 		$fit += 1;

		// 	}

		// 	if($fit == strlen($pattern)){
		// 		break;
		// 	}

		// 	if($text[$pos_text] != $pattern[$pos]){
		// 		$isFound = false;
		// 		foreach($bmbc as $row){
		// 			if($text[$pos_text] == $row["char"]){
		// 				$move += $row["score"];
		// 				$isFound = true;
		// 				break;
		// 			}
		// 		}
		// 		if($isFound == false){
		// 			$move += strlen($pattern);
		// 		}
		// 		echo $text[$pos_text]."-".$pattern[$pos].", pos_text=$pos_text, geser=".$move.", pos = $pos<br><br>";
		// 		$pos_text += $move;

		// 		# reset variable
		// 		$pos = strlen($pattern) - 1;
		// 		$move = 0;
		// 		$fit = 0;

		// 		# increase iteration
		// 		$iteration += 1;
		// 		echo "tahap iterasi-$iteration : <br>";
		// 	}			

		// }
		// if($fit == strlen($pattern)){
		// 	echo "ketemu di iterasi-ke $iteration";
		// }else{
		// 	echo "$pattern tidak ditemukan di kata $text";
		// }
		// echo var_dump($response);

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
}
