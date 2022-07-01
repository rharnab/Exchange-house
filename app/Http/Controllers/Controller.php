<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sanctionScreeCheck(Request $request)
    {

        $name = strtoupper($request->input('input_name'));

        if(!empty($request->input('input_dob'))){
            $input_dob = date('Y', strtotime($request->input('input_dob')));

        }else{
            $input_dob = '';
        }


        if(!empty($request->input('input_country'))){
            $input_country = $request->input('input_country');

        }else{
            $input_country = '';
        }



       $compeer_result  =$this->getCompeerParcent();

        if(!empty($name)){
            $name_reuslt =  $this->ScreenforName($name, $compeer_result['name_parcent']); //geting name screening

        }else{
            $data = [
                'status' => 400,
                'is_error' => true,
                'name'=> '',
                'parcent' => 0,
                'column_name'=> '',
            ];

            return response()->json($data);

        }

         $screening_parcent = $name_reuslt['parcent'];

         if( ($input_dob !='') && ($name_reuslt['status']== 403) && ($name_reuslt['table_name']== 'screen_hm_fst')){

            $dob_result =  $this->ScreenforDob($name_reuslt['column_name'], $name_reuslt['name'], $input_dob, $compeer_result['dob_pacent']); // screen for dob
            $screening_parcent  =(float) $screening_parcent + (float) $dob_result['parcent'];
         }





         if( ($input_country !='') && ($name_reuslt['status']== 403) && ($name_reuslt['table_name']== 'screen_hm_fst')){
            $country_name ='';
            $country_info = DB::table('country_infos')->select('name')->where('id', $input_country)->get();

            if(count($country_info) > 0){
                foreach($country_info as $single_info){
                    $country_name = $single_info->name;
                }
            }
            $country_result =  $this->ScreenforCountry($name_reuslt['column_name'], $name_reuslt['name'], $country_name, $compeer_result['country_parcent']); // screen for dob
            $screening_parcent  = (float) $screening_parcent + (float) $country_result['parcent'];
         }



        if($name_reuslt['status'] == 403){
            if($name_reuslt['parcent'] > 0){

                $data = [
                    'status' => 200,
                    'is_error' => false,
                    'parcent' => str_replace(",", "", number_format($screening_parcent, 2)),
                    'table_name' => $name_reuslt['table_name'],

                ];
                return response()->json($data);
            }

        }else{

            return response()->json($name_reuslt);

        }



    }

    /* ------------get data from ofacs for name screnning --- */
    public function ScreenforName($input_value, $parcent){

        $hm_fast_reulst =  $this->ScreenfromHmFast($input_value, $parcent);
        
        $screen_name = DB::table('screen_ofacs')->select('sdn_name')->where('sdn_name', 'LIKE', '%'.$input_value.'%')->orderBy('id', 'desc')->get();

        

        if($hm_fast_reulst['status'] == 403)
        {
            $hm_fatst_name_result = $hm_fast_reulst['parcent'];
        }else{
            $hm_fatst_name_result = 0;
        }



        //$response=[];
        if(count($screen_name) > 0){

            foreach($screen_name as $single_name){
                //similar_text($name, $single_name->sdn_name, $parcent_result); //string_match

                 $name_result =  100 *  $this->compeerString($input_value, $single_name->sdn_name); // custom function for string match

                 if($hm_fatst_name_result > $name_result)
                 {
                    if($hm_fatst_name_result >= $parcent)
                    {
                        $name_parcent=  ($hm_fatst_name_result * $parcent) / 100;
                        $response = [
                            'status' => 403,
                            'is_error' => false,
                            'name' => $hm_fast_reulst['name'],
                            'parcent' =>$name_parcent,
                            'column_name' => $hm_fast_reulst['column_name'],
                            'table_name' => $hm_fast_reulst['table_name'],

                        ];

                        return $response;

                    }
                 }else{

                    if($name_result >= $parcent)
                    {
                        $name_parcent=  ($name_result * $parcent) / 100;
                        $response = [
                            'status' => 403,
                            'is_error' => false,
                            'name' => $single_name->sdn_name,
                            'parcent' =>$name_parcent,
                            'column_name' => 'sdn_name',
                            'table_name' => 'screen_ofacs',

                        ];

                        return $response;

                    }

                 }
           }

           $response = [
                'status' => 200,
                'is_error' => false,
                'name' => '',
                'parcent' => 0,
                'column_name' =>'sdn_name',
                'table_name' => 'screen_ofacs',
            ];

           return $response;


        }else{

             $response = [
                    'status' => 403,
                    'is_error' => false,
                    'name' => $hm_fast_reulst['name'],
                    'parcent' => $hm_fatst_name_result,
                    'column_name' =>$hm_fast_reulst['column_name'],
                    'table_name' => 'screen_hm_fst',
            ];

            return $response;
        }

    }

    /* ------------get end  data from ofacs for name screnning --- */



    /* ------------get data from hm fast for name screnning --- */
    public function ScreenfromHmFast($input_value, $parcent){

        $screen_result = $this->getSimilarRow($input_value, "name1");


        if($screen_result['status'] == 400){

            $screen_result = $this->getSimilarRow($input_value, "name2");

        }
        if($screen_result['status'] == 400){

            $screen_result = $this->getSimilarRow($input_value, "name3");

        }
        if($screen_result['status'] == 400){

            $screen_result = $this->getSimilarRow($input_value, "name4");
        }
        if($screen_result['status'] == 400){

            $screen_result = $this->getSimilarRow($input_value, "name5");
        }
        if($screen_result['status'] == 400){

            $screen_result = $this->getSimilarRow($input_value, "name6");
        }

        $name_result = $screen_result['screening_result'];

       /*  echo "<pre>";
        print_r($screen_result);
        die; */
        $column_name  = $screen_result['column'];

        if(count($name_result) > 0){
            foreach($name_result as $single_name){

                $parcent_result =  100 *  $this->compeerString($input_value, $single_name->$column_name); // custom function for string match

                \file_put_contents('col.txt', $column_name);
                if($parcent_result >= $parcent)
                {
                   $name_parcent=  ($parcent_result * $parcent) / 100;

                    $response = [
                        'status' => 403,
                        'is_error' => false,
                        'name' => $single_name->$column_name,
                        'parcent' => $name_parcent,
                        'column_name' => $column_name,
                        'table_name' => 'screen_hm_fst',


                    ];

                    return $response;

                }else{

                    $response = [
                        'status' => 200,
                        'is_error' => false,
                        'name' => '',
                        'parcent' => 0,
                        'column_name' => $column_name,
                        'table_name' => 'screen_hm_fst',
                    ];

                }



           }

           return $response;


        }else{

             $response = [
                    'status' => 200,
                    'is_error' => false,
                    'name' => '',
                    'parcent' => 0,
                    'column_name' => $column_name,
                    'table_name' => 'screen_hm_fst',
            ];

            return $response;
        }

    }

    /* ------------get end  data from hm fast for name screnning --- */



    function getSimilarRow($input_value, $column)
    {
        $screen_result = DB::table('screen_hm_fst')->select(['name6', 'name1', 'name2', 'name3', 'name4', 'name5'])
        ->where($column, 'LIKE', '%'.$input_value.'%')
        ->orderBy('sl', 'desc')
        ->get();

        if(count($screen_result) > 0){
           $rows =[
                'status' => 200,
                'is_error' => false,
                'screening_result' => $screen_result,
                'column' => $column
           ];

           return $rows;
        }else{
            $response = [
                    'status' => 400,
                    'is_error' => true,
                    'screening_result' => [],
                    'column' => $column,
            ];

            return $response;
        }
    }


    function compeerString( $string1, $string2 )
    {
        $string1= strtoupper($string1);
        $string2= strtoupper($string2);
        $str1_len = strlen( $string1 );
        $str2_len = strlen($string2);
        // theoretical distance
        $distance = (int) floor(min( $str1_len, $str2_len ) / 2.0);
        // get common characters
        $commons1 = $this->getCommonCharacters( $string1, $string2, $distance );
        $commons2 = $this->getCommonCharacters( $string2, $string1, $distance );
        if( ($commons1_len = strlen( $commons1 )) == 0) return 0;
        if( ($commons2_len = strlen( $commons2 )) == 0) return 0;
        // calculate transpositions
        $transpositions = 0;
        $upperBound = min( $commons1_len, $commons2_len );
        for( $i = 0; $i < $upperBound; $i++){
          if( $commons1[$i] != $commons2[$i] ) $transpositions++;
        }
        $transpositions /= 2.0;
        // return the Jaro distance
        return ($commons1_len/($str1_len) + $commons2_len/($str2_len) + ($commons1_len - $transpositions)/($commons1_len)) / 3.0;
      }



        function getCommonCharacters( $string1, $string2, $allowedDistance )
        {
            $str1_len = strlen($string1);
            $str2_len = strlen($string2);
            $temp_string2 = $string2;
            $commonCharacters='';
            for( $i=0; $i < $str1_len; $i++){
            $noMatch = True;
            // compare if char does match inside given allowedDistance
            // and if it does add it to commonCharacters
            for( $j= max( 0, $i-$allowedDistance ); $noMatch && $j < min( $i + $allowedDistance + 1, $str2_len ); $j++){

                    if( $temp_string2[$j] == $string1[$i] ){
                    $noMatch = False;
                    $commonCharacters .= $string1[$i];
                   // $temp_string2[$j] = '';
                    }


                }
            }
            return $commonCharacters;
        }


        ################################# Screen for dob #########################
        public function ScreenforDob($column, $name, $year, $parcent){

            $screen_dob_result = DB::table('screen_hm_fst')->select('dob')->where($column, $name)->orderBy('sl', 'desc')->get();
            if(count($screen_dob_result) > 0){
                foreach($screen_dob_result as $single_value){

                    $date_of_birth = date('Y', strtotime(trim($single_value->dob)));
                    $dob_result =  100 *  $this->compeerString($year, $date_of_birth); // custom function for string match
                    //file_put_contents('zz.txt', "column =>".$column. " name=>". $name." year =".$year." value =>".$single_value->dob);
                    if(($single_value->dob != '')  && ($dob_result >= $parcent)){

                        $dob_parcent=  ($dob_result * $parcent) / 100;
                        $data =[
                            'status' => 200,
                            'is_error'=> false,
                             'parcent'=> $dob_parcent
                        ];

                        return $data;
                    }else{

                        $data =[
                            'status' => 200,
                            'is_error'=> false,
                             'parcent'=> 0
                        ];

                        return $data;

                    }

                }

                $data =[
                    'status' => 400,
                    'is_error'=> false,
                    'parcent'=> '',
                    'message' => 'date of birth not found'
                ];

                return $data;
            }else{
                $data =[
                    'status' => 400,
                    'is_error'=> false,
                     'parcent'=> '',
                     'message' => 'date of birth not found'
                ];

                return $data;
            }

        }
        ################################# Screen for dob #########################



        ################################# Screen for country #########################
        public function ScreenforCountry($column, $name, $country, $parcent){

            $screen_country_result = DB::table('screen_hm_fst')->select('country')->where($column, $name)->orderBy('sl', 'desc')->get();

            if(count($screen_country_result) > 0){
                foreach($screen_country_result as $single_value){

                    $country_result =  100 *  $this->compeerString($country, $single_value->country); // custom function for string match
                    //file_put_contents('zz.txt', "column =>".$column. " name=>". $name." year =".$country." value =>".$single_value->dob);
                    if(($single_value->country != '')  && ($country_result >= $parcent)){

                        $country_parcent=  ($country_result * $parcent) / 100;
                        $data =[
                            'status' => 200,
                            'is_error'=> false,
                            'parcent'=> $country_parcent
                        ];

                        return $data;
                    }else{

                        $data =[
                            'status' => 200,
                            'is_error'=> false,
                             'parcent'=> 0
                        ];

                        return $data;

                    }

                }

                $data =[
                    'status' => 400,
                    'is_error'=> false,
                    'parcent'=> '',
                    'message' => 'Country not found'
                ];

                return $data;
            }else{
                $data =[
                    'status' => 400,
                    'is_error'=> false,
                     'parcent'=> '',
                     'message' => 'Country not found'
                ];

                return $data;
            }

        }
        ################################# Screen for country #########################


        public function getCompeerParcent()
        {
            $compeer_result = DB::table('sanction_para_meters')->first();

            $data =[
                'name_parcent' => $compeer_result->name,
                'dob_pacent' => $compeer_result->dob,
                'country_parcent' => $compeer_result->country,
            ];

            return $data;
        }


        public function excelCheck($name, $dob, $country) {
            $name = strtoupper($name);

            if(!empty($dob)){
                $input_dob = date('Y', strtotime($dob));

            }else{
                $input_dob = '';
            }


            if(!empty($country)){
                $input_country = $country;

            }else{
                $input_country = '';
            }



            $compeer_result  =$this->getCompeerParcent();

            if(!empty($name)){
                $name_reuslt =  $this->ScreenforName($name, $compeer_result['name_parcent']); //geting name screening

            }else{
                $data = [
                    'status' => 400,
                    'is_error' => true,
                    'name'=> '',
                    'parcent' => 0,
                    'column_name'=> '',
                ];

                return response()->json($data);

            }

            $screening_parcent = $name_reuslt['parcent'];

            if( ($input_dob !='') && ($name_reuslt['status']== 403) && ($name_reuslt['table_name']== 'screen_hm_fst')){

                $dob_result =  $this->ScreenforDob($name_reuslt['column_name'], $name_reuslt['name'], $input_dob, $compeer_result['dob_pacent']); // screen for dob
                $screening_parcent  =(float) $screening_parcent + (float) $dob_result['parcent'];
            }





            if( ($input_country !='') && ($name_reuslt['status']== 403) && ($name_reuslt['table_name']== 'screen_hm_fst')){
                $country_name ='';
                $country_info = DB::table('country_infos')->select('name')->where('id', $input_country)->get();

                if(count($country_info) > 0){
                    foreach($country_info as $single_info){
                        $country_name = $single_info->name;
                    }
                }
                $country_result =  $this->ScreenforCountry($name_reuslt['column_name'], $name_reuslt['name'], $country_name, $compeer_result['country_parcent']); // screen for dob
                $screening_parcent  = (float) $screening_parcent + (float) $country_result['parcent'];
            }



            if($name_reuslt['status'] == 403){
                if($name_reuslt['parcent'] > 0){

                    $data = [
                        'status' => 200,
                        'is_error' => false,
                        'parcent' => str_replace(",", "", number_format($screening_parcent, 2)),
                        'table_name' => $name_reuslt['table_name'],

                    ];
                    return $data;
                }

            }else{

                return $name_reuslt;

            }


        }


}
