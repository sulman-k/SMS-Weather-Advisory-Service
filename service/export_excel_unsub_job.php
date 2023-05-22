<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 2/3/2020
 * Time: 6:11 PM
 */


require_once('PHPExcel/PHPExcel.php');
require_once('PHPExcel/PHPExcel/IOFactory.php');
require_once('PHPExcel/PHPExcel/Writer/Excel2007.php');

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$response = array("success" => -100);
$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];
$id=isset($_GET['id'])?$_GET['id']:'';


/*$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';
$is_dt = isset($_GET['is_dt']) ? $_GET['is_dt'] : 0;
$st = isset($_GET['st']) ? $_GET['st'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';*/


/*if(!strcmp($state, "kam"))
{
    $conn = $km_conn;
    $state = 'missouri';
}*/
if (isset($userid) && in_array($role, $bulk_unsub)) {
    /*$st = $st . ' 00:00:00';
    $end = $end . ' 23:59:59';


    $date_check = '';
    $cellno_check = '';

    if (!$is_dt) {

        //$date_check = " AND  cellno LIKE '%$cellno%' ";
        if(strlen($cellno) == 11){
            $date_check = " WHERE cellno = '$cellno' ";
        }else if(strlen($cellno) > 0){
            $date_check = " WHERE cellno LIKE '%$cellno%' ";
        }

    } else if ($is_dt) {
        $date_check = " WHERE sub_dt BETWEEN '$st' AND '$end'";
    }

    doLog('[export_excel_kam][NEW][start date: ' . $st . ' ][NEW][end date: ' . $end . ' ] [NEW][cellno: ' . $cellno . ' ][is date : '. $is_dt . ']');*/


    $sql="SELECT job_$id.cellno, list_$id.payplancode, job_$id.response_desc,job_$id.sub_dt,job_$id.unsub_dt,job_$id.unsub_status,job_$id.total_charged_amount FROM list_$id INNER JOIN job_$id ON list_$id.cellno=job_$id.cellno;";

    doLog('[export_excel_unsub_job][NEW][sql: ' . $sql . ' ]');

    function setBorders($objSheet, $id)
    {
        $objSheet->getStyle($id)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($id)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($id)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($id)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }

    function BindEvents()
    {
        global $CCSEvents;
        $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    }

    //echo date('H:i:s'), " STARTING ...", EOL;
    global $ARR_JOB_CELL_STATUS_SEARCH;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objSheet = $objPHPExcel->getActiveSheet();
    $objSheet->setTitle('Bulk unsub job summary');
    $rowCount = 1;
    $objSheet->getColumnDimension('A')->setAutoSize(true);

    doLog('[export_excel_unsub_job][NEW][sql: Excel obj is created ]');

    try {

        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(1) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(2) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(3) . '')->setWidth(15);

        $objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objSheet->setCellValue('A1', 'Bulk unsub job report');
        $objSheet->mergeCells('A1:C2');

        $objSheet->getStyle('A1:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objSheet->getStyle('A1:C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("00ACE7");
        $objSheet->getStyle('A1')->getFont()->getColor()->setARGB("FFFFFFFF");

        setBorders($objSheet, 'A1:C2');
        setBorders($objSheet, 'A4');
        setBorders($objSheet, 'B4');
        setBorders($objSheet, 'C4');
        setBorders($objSheet, 'D4');
        setBorders($objSheet, 'F4');
        setBorders($objSheet, 'G4');




        $objSheet->setCellValue('A4', 'CELL NO');
        $objSheet->setCellValue('B4', 'STATUS');
        $objSheet->setCellValue('C4', 'SUBSCRIPTION DATE');
        $objSheet->setCellValue('D4', 'UNSUBSCRIPTION DATE');
        $objSheet->setCellValue('E4', 'RESPONSE');
        $objSheet->setCellValue('F4', 'PAYPLAN CODE');
        $objSheet->setCellValue('G4', 'TOTAL TRANSACTION AMOUNT');



        $objSheet->getStyle('A4')->getFont()->setBold(true);
        $objSheet->getStyle('B4')->getFont()->setBold(true);
       $objSheet->getStyle('C4')->getFont()->setBold(true);
       $objSheet->getStyle('D4')->getFont()->setBold(true);
       $objSheet->getStyle('E4')->getFont()->setBold(true);
       $objSheet->getStyle('F4')->getFont()->setBold(true);
       $objSheet->getStyle('G4')->getFont()->setBold(true);




        $rowCount = 6;

        $result = $bu_conn->query($sql);
        //printf('res',$result);


        // doLog('[export_excel_unsub_job][NEW][Query_is_executed ]'.$result);

        try {
            if ($result === false) {
                throw new Exception("Query failed: " . $bu_conn->error);
                
            }
            
            $rowCount = 6;
            while ($row = $result->fetch_assoc()) {
                $payplancode = $row['payplancode'];
                $cellno = $row['cellno'];
                $response_desc = $row['response_desc'];
                $sub_dt = $row['sub_dt'];
                $unsub_dt = $row['unsub_dt'];
                $unsub_status = $row['unsub_status'];

                
               // doLog('[export_excel_unsub_job][NEW][Query is executed ]'.$unsub_status);
                // echo ('here' . $row ['cellno']);
    
                if($unsub_status==100){
                    $unsub_status='Successful';
                }else if($unsub_status==200){
                    $unsub_status='Not active subscriber';
                    $unsub_dt='N/A';
                }else if($unsub_status==300){
                    $unsub_status='Unsuccessful';
                }
                $total = $row['total_charged_amount'];
    
    
                $objSheet->setCellValueByColumnAndRow(0, $rowCount, $cellno);
                $objSheet->setCellValueByColumnAndRow(1, $rowCount, $unsub_status);
                $objSheet->setCellValueByColumnAndRow(2, $rowCount, $sub_dt);
                $objSheet->setCellValueByColumnAndRow(3, $rowCount, $unsub_dt);
                $objSheet->setCellValueByColumnAndRow(4, $rowCount, $response_desc);
                $objSheet->setCellValueByColumnAndRow(5, $rowCount, $payplancode);
                $objSheet->setCellValueByColumnAndRow(6, $rowCount, $total);


    
    
                $rowCount++;
    
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
               

        doLog('[export_excel_unsub_job][NEW][Excel2007]');

        $fileName = 'Bulk unsubscribers report';
        $fileName .= '_' . date(ymdhi);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");

        $response['success'] = 100;
    } catch (Exception $e) {
        doLog('[export_excel_unsub_job][Exception][' . $e . ']');
    }

} 
else {
    header('Location: ../php/logout.php');
}



