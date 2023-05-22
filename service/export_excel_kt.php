<?php
/**
 * Created by PhpStorm.
 * User: mm
 * Date: 9/1/2020
 * Time: 11:41 AM
 */




require_once('PHPExcel/PHPExcel.php');
require_once('PHPExcel/PHPExcel/IOFactory.php');
require_once('PHPExcel/PHPExcel/Writer/Excel2007.php');

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$response = array("success" => -100);
$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$state = isset($_GET['state']) ? $_GET['state'] : null;
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';
$is_dt = isset($_GET['is_dt']) ? $_GET['is_dt'] : 0;
$st = isset($_GET['st']) ? $_GET['st'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';


if(!strcmp($state, "kt"))
{
    $conn = $kt_conn;
    $state = 'missouri';
}
if (isset($userid) && in_array($role, $cro)) {
    $st = $st . ' 00:00:00';
    $end = $end . ' 23:59:59';


    $date_check = '';
    $cellno_check = '';

    if (!$is_dt) {

        //$date_check = " AND  cellno LIKE '%$cellno%' ";
        if(strlen($cellno) == 11){
            $date_check = " WHERE cellno = '$cellno' ";
        }else if(strlen($cellno) > 0){
            $date_check = " WHERE cellno like '%$cellno%' ";
        }

    } else if ($is_dt) {
        $date_check = " WHERE sub_dt BETWEEN '$st' AND '$end'";
    }

    doLog('[export_excel_kt][NEW][start date: ' . $st . ' ][NEW][end date: ' . $end . ' ] [NEW][cellno: ' . $cellno . ' ][is date : '. $is_dt . ']');

    $sql = "SELECT cellno,sub_dt,unsub_dt,sub_mode,unsub_mode,charge_attempt_dt,last_charge_dt,next_charge_dt,grace_expire_dt FROM subscriber $date_check";

    doLog('[export_excel_kt][NEW][sql: ' . $sql . ' ]');

    function setBorders($objSheet, $cell)
    {
        $objSheet->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objSheet->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
    $objSheet->setTitle('K-Tahafuz Subscriber Report');
    $rowCount = 1;
    $objSheet->getColumnDimension('A')->setAutoSize(true);

    doLog('[export_excel_kat][NEW][sql: Excel obj is created ]');

    try {

        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(1) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(2) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(3) . '')->setWidth(15);

        $objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objSheet->setCellValue('A1', 'K-Tahafuz Subscriber Report');
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


        $objSheet->setCellValue('A4', 'SUBSCRIBER CELL NO');
        $objSheet->setCellValue('B4', 'SUBSCRIPTION DATE');
        $objSheet->setCellValue('C4', 'UNSUBSCRIPTION DATE');
        $objSheet->setCellValue('D4', 'SUBSCRIPTION MODE');
        $objSheet->setCellValue('E4', 'UNSUBSCRIPTION MODE');
        $objSheet->setCellValue('F4', 'CHARGE ATTEMPT DATE');
        $objSheet->setCellValue('G4', 'LAST CHARGE DATE');
        $objSheet->setCellValue('H4', 'NEXT CHARGE DATE');
        $objSheet->setCellValue('I4', 'GRACE EXPIRE DATE');


        $objSheet->getStyle('A4')->getFont()->setBold(true);
        $objSheet->getStyle('B4')->getFont()->setBold(true);
        $objSheet->getStyle('C4')->getFont()->setBold(true);
        $objSheet->getStyle('D4')->getFont()->setBold(true);
        $objSheet->getStyle('E4')->getFont()->setBold(true);
        $objSheet->getStyle('F4')->getFont()->setBold(true);
        $objSheet->getStyle('G4')->getFont()->setBold(true);
        $objSheet->getStyle('H4')->getFont()->setBold(true);
        $objSheet->getStyle('I4')->getFont()->setBold(true);

        $rowCount = 5;

        $result = $conn->query($sql);

        doLog('[export_excel_kt][NEW][Query is executed ]');

        while ($row = $result->fetch_assoc()) {
            $rider_cellno = $row['cellno'];
            $sub_dt = $row['sub_dt'];
            $unsub_dt = $row['unsub_dt'];
            $sub_mode = $row['sub_mode'];
            $unsub_mode = $row['unsub_mode'];
            $charge_attempt_dt = $row['charge_attempt_dt'];
            $last_charge_dt = $row['last_charge_dt'];
            $next_charge_dt = $row['next_charge_dt'];
            $grace_expire_dt = $row['grace_expire_dt'];

            $objSheet->setCellValueByColumnAndRow(0, $rowCount, $rider_cellno);
            $objSheet->setCellValueByColumnAndRow(1, $rowCount, $sub_dt);
            $objSheet->setCellValueByColumnAndRow(2, $rowCount, $unsub_dt);
            $objSheet->setCellValueByColumnAndRow(3, $rowCount, $sub_mode);
            $objSheet->setCellValueByColumnAndRow(4, $rowCount, $unsub_mode);
            $objSheet->setCellValueByColumnAndRow(5, $rowCount, $charge_attempt_dt);
            $objSheet->setCellValueByColumnAndRow(6, $rowCount, $last_charge_dt);
            $objSheet->setCellValueByColumnAndRow(7, $rowCount, $next_charge_dt);
            $objSheet->setCellValueByColumnAndRow(8, $rowCount, $grace_expire_dt);

            $rowCount++;

        }

        doLog('[export_excel_kt][NEW][Excel2007]');

        $fileName = 'KT_subscriber_report';
        $fileName .= '_' . date(ymdhi);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");

        $response['success'] = 100;
    } catch (Exception $e) {
        doLog('[export_excel_kt][Exception][' . $e . ']');
    }

} else {
    header('Location: ../php/logout.php');
}


