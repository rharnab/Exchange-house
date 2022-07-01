<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanctionFileUpload;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ScreenFileUploadController extends Controller
{

    public function sanctionScreenFileIndex() {
        return view('admin.sanction-screen.index');
    }


    public function sanctionScreenFileStore(Request $request) {
        $request->validate([
            //'provider_name' => 'required',
            'file_name' => 'required|mimes:xls,xlsx',
        ],[
            //'provider_name.required' => 'Select a sanction provider',
            'file_name.required' => 'Upload a file and must be xls or xlsx',

        ]);
//        $dataTest = $this->excelCheck('Latif Nusayyif Jasim Al-Dulaymi', '01/01/1941', '');
//        echo "<pre>";
//        print_r($dataTest);
//        echo $dataTest['parcent'];
//        die;

        $the_file = $request->file('file_name');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'F', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $name = $sheet->getCell( 'B' . $row )->getValue();
                $country = $sheet->getCell( 'C' . $row )->getValue();
                $dob = $sheet->getCell( 'D' . $row )->getValue();
                $date = $sheet->getCell( 'D' . $row )->getValue();
                $date = str_replace('/', '-', $date);
                $dob = date('Y-m-d', strtotime($date));
                $SanctionData = $this->excelCheck($name, $dob, $country);

                $score =  isset($SanctionData['parcent']) ? $SanctionData['parcent'] : 0;
                $table =  isset($SanctionData['table_name']) ? $SanctionData['table_name'] : 'NULL';
                $data[] = [
                    'name' => $name,
                    'country' => $country,
                    'dob' => $dob,
                    'score' => $score,
                    'source_name' => $table,
                    'created_at' => now()
                ];
                $startcount++;
            }
            SanctionFileUpload::truncate();
            DB::table('sanction_file_uploads')->insert($data);
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->with('message','There was a problem uploading the data!');
        }
        return back()->with('message','Data has been created successfully!!');
    }


    public function ExportExcel($customer_data) {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="sanctionResult.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    function exportData() {
        $data = DB::table('sanction_file_uploads')->orderBy('id', 'DESC')->get();
        $data_array [] = array("FullName","CountryName","BirthDate","Score","Source");
        foreach($data as $item) {
            $data_array[] = array(
                'FullName' =>$item->name,
                'CountryName' => $item->country,
                'BirthDate' => $item->dob,
                'Score' => $item->score,
                'Source' => $item->source_name,
            );
        }
        $this->ExportExcel($data_array);
    }

}
