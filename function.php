<?php
function clean_text($string)
{
  $string = rtrim($string);
  $string = stripslashes($string);
  $string = htmlspecialchars($string);
  return $string;
}

function convert_string($action, $string)
{
  $output = '';
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'eaiYYkYTysia2lnHiw0N0vx7t7a3kEJVLfbTKoQIx5o=';
  $secret_iv = 'eaiYYkYTysia2lnHiw0N0';
  // hash
  $key = hash('sha256', $secret_key);
  $initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
  if ($string != '') {
    if ($action == 'encrypt') {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $initialization_vector);
      $output = base64_encode($output);
    }
    if ($action == 'decrypt') {
      $output = base64_decode($string);
      $output = openssl_decrypt($output, $encrypt_method, $key, 0, $initialization_vector);
    }
  }
  return $output;
}

// Insert Record to the table
function insert_record($connect, $table, $field)
{
  $sql = "";
  $sql .= "INSERT INTO " . $table;
  $sql .= " (" . implode(", ", array_keys($field)) . ") VALUES ";
  $sql .= "('" . implode("', '", array_values($field)) . "')";
  $query = mysqli_query($connect, $sql);
  if ($query) {
    return true;
  }
}

function update_record($connect, $table, $fields, $where)
{
  $sql = "";
  $condition = "";
  foreach ($where as $key => $value) {
    $condition .= $key . "='" . $value . "' AND ";
  }
  $condition = substr($condition, 0, -5);

  foreach ($fields as $key => $value) {
    $sql .= $key . "='" . $value . "', ";
  }
  $sql = substr($sql, 0, -2);
  $sql = "UPDATE " . $table . " SET " . $sql . " WHERE " . $condition;
  if (mysqli_query($connect, $sql)) {
    return true;
  }
}

function delete_record($connect, $table, $where)
{
  $condition = "";
  foreach ($where as $key => $value) {
    $condition .= $key . "='" . $value . "' AND ";
  }
  $condition = substr($condition, 0, -5);
  $sql = "DELETE FROM " . $table . " WHERE " . $condition;
  if (mysqli_query($connect, $sql)) {
    return true;
  }
}

function purchase_details($connect, $id)
{
  $output='';
  $query = "SELECT * FROM purchasedetail_tbl pdt LEFT JOIN product_tbl pt ON pt.product_id=pdt.product_id WHERE pdt.pid=".$id;
  $result = mysqli_query($connect, $query);
  while ($row = mysqli_fetch_assoc($result)) 
  {
    $output .= $row['code'].'- W: '.$row['weight'].' V: '.$row['grand_total']."<br>";
  }
  return $output;
}

function sale_details($connect, $id)
{
  $output='';
  $query = "SELECT * FROM saledetail_tbl sdt LEFT JOIN product_tbl pt ON pt.product_id=sdt.product_id WHERE sdt.sid=".$id;
  $result = mysqli_query($connect, $query);
  while ($row = mysqli_fetch_assoc($result)) 
  {
    $output .= $row['code'].'- W: '.$row['weight'].' V: '.$row['grand_tot']."<br>";
  }
  return $output;
}
function get_total_all_records($connect, $tablename)
{
  $statement = mysqli_query($connect, "SELECT * FROM " . $tablename . " ");
  return mysqli_num_rows($statement);
}

function party_type($party_type)
{
  if ($party_type == 1) {
    $output = 'DEBTORS';
  } else if ($party_type == 2) {
    $output = 'CREDITORS';
  } else if ($party_type == 3) {
    $output = 'PARTY ACCOUNT';
  } else if ($party_type == 4) {
    $output = 'EXPENSES';
  } else if ($party_type == 5) {
    $output = 'LOAN ACCOUNT';
  } else if ($party_type == 6) {
    $output = 'GIRVI ACCOUNT';
  } else if ($party_type == 7) {
    $output = 'BANK ACCOUNT';
  } else if ($party_type == 8) {
    $output = 'CAPITAL ACCPUNT';
  } else if ($party_type == 9) {
    $output = 'STAFF ACCOUNT';
  } else if ($party_type == 10) {
    $output = 'SELL / PURCHASE';
  } else if ($party_type == 11) {
    $output = 'INCOME';
  } else if ($party_type == 12) {
    $output = 'SGP NEW';
  }
  return $output;
}
function list_value($connect, $tablename, $searchvalue, $searchid, $which)
{
  $output = '<option value="">' . $which . '</option>';
  $query = "SELECT " . $searchvalue . " as value, " . $searchid . " as id FROM " . $tablename . " ";
  $run = mysqli_query($connect, $query);
  while ($row = mysqli_fetch_array($run)) {
    $output .= '<option value="' . $row['id'] . '">' . $row['value'] . '</option>';
  }
  return $output;
}

function return_value($connect, $tablename, $search_value, $where)
{
  $statement = mysqli_query($connect, "SELECT " . $search_value . " FROM " . $tablename . " WHERE " . $where . " ");
  $row = mysqli_fetch_row($statement);
  return $row[0];
}
