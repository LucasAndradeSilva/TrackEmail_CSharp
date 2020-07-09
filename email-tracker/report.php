<?php
/**
 * report.php
 * generate report
 * @author Tayyib Oladoja
 * @version 1.0
 * @date 10-05-2016
 * @website www.tayyiboladoja.com
 * @package Email Tracker
**/

$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
/*** $message = a message saying we have connected ***/

/*** set the error mode to excptions ***/
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*** prepare the select statement ***/
$stmt = $dbh->prepare("SELECT recipent_name, email_address, subject, ip, city,country, device_info, count_open, date_sent, first_opened, last_opened  FROM email_log");

/*** bind the parameters ***/
//$stmt->bindParam(':date', date("d-m"), PDO::PARAM_STR);

/*** execute the prepared statement ***/
$stmt->execute();


echo "<table class='tg'>
			<tr>
			    <th class='tg-yw4l'>Name</th>
			    <th class='tg-yw4l'>Email</th>
			    <th class='tg-yw4l'>Subject</th>
				<th class='tg-yw4l'>City</th>
			    <th class='tg-yw4l'>Country</th>
			    <th class='tg-yw4l'>Device Info</th>
			    <th class='tg-yw4l'>Number of Open</th>
			    <th class='tg-yw4l'>Date Sent</th>
			    <th class='tg-yw4l'>First Opened</th>
				<th class='tg-yw4l'>Last Opened</th>
			 </tr>";

while ($row = $stmt->fetch()) {
    echo "<tr>
			     <td class='tg-yw4l'>" . $row['recipent_name'] . "</td>
 			     <td class='tg-yw4l'>" . $row['email_address'] . "</td>
				 <td class='tg-yw4l'>" . $row['subject'] . "</td>
 			     <td class='tg-yw4l'>" . $row['city'] . "</td>
  			     <td class='tg-yw4l'>" . $row['country'] . "</td>
  			     <td class='tg-yw4l'>" . $row['device_info'] . "</td>
			     <td class='tg-yw4l'>" . $row['count_open'] . "</td>
 			     <td class='tg-yw4l'>" . $row['date_sent'] . "</td>
			     <td class='tg-yw4l'>" . $row['first_opened'] . "</td>
 			     <td class='tg-yw4l'>" . $row['last_opened'] . "</td>
 			    </tr>";
}
echo "</table>";
?>


