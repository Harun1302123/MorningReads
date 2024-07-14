<?php

require 'dbCon.php'; /* return name of current default database */
require 'mail_setting.php';
require "cron_job_audit.php";

/* return name of current default database */


/*
 * Sending to PDF Server from pdf_print_requests table
 */

$time_index = 0;
$rowcount = 0;
$comment = '';

if ($result0 = $mysqli->query("SELECT * FROM pdf_print_requests_queue WHERE job_sending_status=0 and prepared_json=1 ORDER BY id DESC LIMIT 10")) {
    $rowcount = mysqli_num_rows($result0);
    $requestCounter = 0;
    while ($row = $result0->fetch_assoc()) {

//        print_r($row);exit;
        $id = $row['id'];
        $requested_url = $row['url_requests'];
        $encoded_data = str_replace("\"{", "{", $requested_url);
        $encoded_data = str_replace("}\"", "}", $encoded_data);
        $requested_url = rawurlencode($encoded_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $row['pdf_server_url'] . "api/new-job");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "requestData=$requested_url");
// receive server response ...
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 150);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
//        dd($response);

        echo curl_errno($ch);
        echo curl_error($ch);
        curl_close($ch);

        $dataResponse = json_decode($response);
//        echo '<pre>';print_r($dataResponse);exit;

        $no_of_try = $row['no_of_try_job_sending'] + 1; // indicates number of trying to send the data to the PDF server

        if (!empty($dataResponse->response) && ($dataResponse->response->status == -1 || $dataResponse->response->status == 1)) {
            $status = 1; // data sent
        } else if ($no_of_try > 20) {
            $status = -9; // data is invalid, abort sending
        } else {
            $status = 0; // data not send yet, will try again
        }

        $sql = "UPDATE pdf_print_requests_queue SET job_sending_status=$status, no_of_try_job_sending=$no_of_try  WHERE id=$id";
        $mysqli->query($sql);
        $requestCounter++;
    }
    echo "<br/>No of Pdf print request is : " . $requestCounter . "<br/>";

    $comment = "sending";
    cronAuditSave($time_index, $rowcount, $comment, $mysqli);

    $result0->close();
}
/* End of Sending to PDF Server from pdf_print_requests table */


/*
 * Updating certificate related rows of Application Base table
 */

if ($result1 = $mysqli->query("SELECT * FROM pdf_print_requests_queue WHERE job_receiving_status=0  and job_sending_status=1 ORDER BY id DESC LIMIT 10")) {
//if ($result1 = $mysqli->query("SELECT * FROM pdf_print_requests_queue   ORDER BY id DESC LIMIT 5")) {
    $rowcount = mysqli_num_rows($result1);
    while ($row = $result1->fetch_assoc()) {


        $id = $row['id'];
        $app_id = $row['app_id'];
        $process_type_id = $row['process_type_id'];
        $other_significant_id = $row['others_significant_id'];
        $reg_key = $row['reg_key'];
        $pdf_type = $row['pdf_type'];
        $certificate_name = $row['certificate_name'];
        $table_name = $row['table_name'];
        $field_name = $row['field_name'];

        $data = array();
        $data['data'] = array(
            'reg_key' => $reg_key, // Authentication key
            'pdf_type' => $pdf_type, // letter type
            'ref_id' => $app_id, //app_id
            'param' => array(
//                'app_id' => (int)$app_id, // app_id
                'app_id' => $app_id, // app_id
//                'service_id' => (int)$process_type_id, // service_id of each module
//                'other_significant_id' => (int)$other_significant_id, // default 0, for gate pass: gp_id, for undertaking: tracking no etc.
            )
        );

        $data1 = json_encode($data);
        $url = $row['pdf_server_url'] . "api/job-status?requestData=$data1";
//        print_r($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 150);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo "\n<br />";
            $response = '';
        } else {
            curl_close($ch);
        }
        $dataResponse = json_decode($response);
//        dd($dataResponse);

        $attachmentUrl = '';
        $doc_id = '';
        $no_of_try = $row['no_of_try_job_receving'] + 1; // indicates number of trying to send the data to the PDF server
        $status = 0;
        if (!empty($dataResponse->response) && $dataResponse->response->status == 1) {
            $attachmentUrl = $dataResponse->response->download_link;
            $doc_id = $dataResponse->response->doc_id;

            $sql3 = "UPDATE " . $table_name . "  SET " . $field_name . "='" . $attachmentUrl . "' WHERE id=$app_id";
            // echo $sql3;exit;
            $mysqli->query($sql3);
            $status = 1;
        }
//        for -1
        if ($no_of_try > 25) {
            $status = -9; // data is invalid, abort sending
        }


        $sql2 = "UPDATE pdf_print_requests_queue SET job_receiving_status=$status, no_of_try_job_receving=$no_of_try,
                 certificate_link='" . $attachmentUrl . "', doc_id='" . $doc_id . "' WHERE id='$id'";
        $mysqli->query($sql2);
        $requestCounter++;

    }

    $comment = "receiving";
    cronAuditSave($time_index, $rowcount, $comment, $mysqli);

    $result1->close();

}
/* End of updating certificate related rows of Application Base table */

cronAuditSave($time_index, $rowcount, $comment, $mysqli);

$mysqli->close();
if ($requestCounter == 0) {
    echo '<br/>No PDF in queue to send! ' . date("j F, Y, g:i a");
}
die();