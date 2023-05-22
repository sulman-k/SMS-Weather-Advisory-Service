<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 2/3/2020
 * Time: 8:12 PM
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
    if($id==''){
        $sql = "SELECT b.generated_by,b.upload_dt ,s.paid_wall_name FROM bulk_sub_unsub_job b join services s  where s.paid_wall_id=b.paid_wall_id ";
    }else {
        $sql = "SELECT b.generated_by,b.upload_dt ,s.paid_wall_name FROM bulk_sub_unsub_job b join services s  where s.paid_wall_id=b.paid_wall_id and  b.id='$id'";
    }
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

    doLog('[export_excel_unsub_job_activity][NEW][sql: Excel obj is created ]');

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


        $objSheet->setCellValue('A4', 'User');
        $objSheet->setCellValue('B4', 'SERVICE');
        $objSheet->setCellValue('C4', 'DATE OF UNSUB');




        $objSheet->getStyle('A4')->getFont()->setBold(true);
        $objSheet->getStyle('B4')->getFont()->setBold(true);
        $objSheet->getStyle('C4')->getFont()->setBold(true);



        $rowCount = 5;

        $result = $bu_conn->query($sql);

        doLog('[export_excel_unsub_job_activity][NEW][Query is executed ]');

        while ($row = $result->fetch_assoc()) {
            $generated_by = $row['generated_by'];
            $service = $row['paid_wall_name'];
            $upload_dt = $row['upload_dt'];


            $objSheet->setCellValueByColumnAndRow(0, $rowCount, $generated_by);
            $objSheet->setCellValueByColumnAndRow(1, $rowCount, $service);
            $objSheet->setCellValueByColumnAndRow(2, $rowCount, $upload_dt);



            $rowCount++;

        }

        doLog('[export_excel_unsub_job_activity][NEW][Excel2007]');

        $fileName = 'Bulk unsubscribers report';
        $fileName .= '_' . date(ymdhi);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName .'.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

        $objWriter->save("php://output");

        $response['success'] = 100;
    } catch (Exception $e) {
        doLog('[export_excel_unsub_job_activity][Exception][' . $e . ']');
    }

} else {
    header('Location: ../php/logout.php');
}



