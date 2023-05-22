<?php

require_once('PHPExcel/PHPExcel.php');
require_once('PHPExcel/PHPExcel/IOFactory.php');
require_once('PHPExcel/PHPExcel/Writer/Excel2007.php');

require_once('../php/in_common.php');
require_once('../php/in_dbConnection.php');

$response = array("success" => -100);
$userid = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = $_SESSION['role'];

$is_dt = isset($_GET['is_dt']) ? $_GET['is_dt'] : 0;
$st = isset($_GET['st']) ? $_GET['st'] : '';
$state  = isset($_GET['state']) ? $_GET['state'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';
$cellno = isset($_GET['cellno']) ? $_GET['cellno'] : '';

if(!strcmp($state, "kaw")){
    $conn = $ka_conn;
    $state = "state = 'missouri' and ";

}else{
    $state=' ';
}

if (isset($userid) && in_array($role, $cro)) {

    $st = $st . ' 00:00:00';
    $end = $end . ' 23:59:59';

    $condition = '';

    if (strlen($cellno) == 11 && $is_dt != 1) {

        $condition = " AND  cellno = '$cellno' ";
    }else if(strlen($cellno)>0){
        $condition="AND cellno like '%$cellno%'";
    } else if ($is_dt) {
        $condition = " AND request_dt BETWEEN '$st' AND '$end'";
    }


    doLog('[export_excel][NEW][start date: ' . $st . ' ][NEW][end date: ' . $end . ' ] [NEW][is date : '. $is_dt . ']');


    $sql = "SELECT cellno,state,create_dt FROM help_requests WHERE ".$state." status < 0  ".$condition." ORDER BY request_dt desc";

    doLog('[export_excel][NEW][sql: ' . $sql . ' ]');

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
    $objSheet->setTitle('Help Request Report');
    $rowCount = 1;
    $objSheet->getColumnDimension('A')->setAutoSize(true);

    doLog('[export_excel][NEW][sql: Excel obj is created ]');

    try {

        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(1) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(2) . '')->setWidth(15);
        $objSheet->getColumnDimension('' . PHPExcel_Cell::stringFromColumnIndex(3) . '')->setWidth(15);

        $objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objSheet->setCellValue('A1', 'KZS Help Request Report');
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

        $objSheet->setCellValue('A4', 'CELL NO');
        $objSheet->setCellValue('B4', 'state');
        $objSheet->setCellValue('C4', 'REQUEST DATE/TIME');
        $objSheet->setCellValue('D4', 'REQUEST STATUS');


        $objSheet->getStyle('A4')->getFont()->setBold(true);
        $objSheet->getStyle('B4')->getFont()->setBold(true);
        $objSheet->getStyle('C4')->getFont()->setBold(true);
        $objSheet->getStyle('D4')->getFont()->setBold(true);

        $rowCount = 5;

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {

            $cellno = $row['cellno'];
            $state=$row['state'];
            $create_dt = $row['create_dt'];
            $sts = 'pending';

            $objSheet->setCellValueByColumnAndRow(0, $rowCount, $cellno);
            $objSheet->setCellValueByColumnAndRow(1, $rowCount, $state);
            $objSheet->setCellValueByColumnAndRow(2, $rowCount, $create_dt);
            $objSheet->setCellValueByColumnAndRow(3, $rowCount, $sts);

            $rowCount++;

        }

        doLog('[export_excel][NEW][Excel2007]');

        $fileName = 'mAgri_help_request_report';
        $fileName .= '_' . date(ymdhi);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save("php://output");

        $response['success'] = 100;
    } catch (Exception $e) {
        doLog('[export_excel][Exception][' . $e . ']');
    }

} else {
    header('Location: ../php/logout.php');
}



