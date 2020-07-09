<?php
/**
 * record.php
 * Checks if the emails has been read.
 * @author Tayyib Oladoja
 * @version 1.0
 * @date 10-05-2016
 * @website www.tayyiboladoja.com
 * @package Email Tracker
**/

if( !empty( $_GET['log'] ) == 'true')
{
    
	include "config.php";
	date_default_timezone_set('GMT');
	
	
    header( 'Content-Type: image/gif' );
    
    //Assign the user and message to sanitized variables
	$user_id = filter_var( $_GET['user_id'] );
    $recipent_name = filter_var( $_GET['name'] );
    $subject = filter_var( $_GET['subject'] );
	$email_address=filter_var( $_GET['email'] );
	$date_sent = filter_var( $_GET['date'] );
	$ip= $_SERVER['REMOTE_ADDR'];
	$device_info= $_SERVER['HTTP_USER_AGENT'];
	
	//get ip details
	$ip_details = json_decode(file_get_contents("http://ipinfo.io/".$ip."/json"));
	$city = $ip_details->city;
	$country = $ip_details->country;
	$count_open= 1;
	
	
		$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		
        
        $stmt = $dbh->prepare("SELECT id from email_log WHERE subject =:subject and email_address= :email_address ");
		$stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
		$stmt->bindParam(':email_address', $email_address, PDO::PARAM_STR); 
		 
        //$stmt->bindParam(':date', date("d-m"), PDO::PARAM_STR);
        $stmt->execute();
		
		 /*** check for a result ***/
        $result = $stmt->fetchColumn();
		
		 /*** if we have no result then fail boat ***/
        if($result == false)
        {
                
			/*** prepare the insert ***/
			$stmt2 = $dbh->prepare("INSERT INTO email_log (user_id, recipent_name, email_address, subject, ip, city, country, device_info, count_open, date_sent, first_opened ) VALUES (:user_id, :recipent_name, :email_address, :subject, :ip, :city, :country, :device_info, :count_open, :date_sent, :first_opened )");

			/*** bind the parameters ***/
			$stmt2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
			$stmt2->bindParam(':recipent_name', $recipent_name, PDO::PARAM_STR);
			$stmt2->bindParam(':email_address', $email_address, PDO::PARAM_STR); 
			$stmt2->bindParam(':subject', $subject, PDO::PARAM_STR);
			$stmt2->bindParam(':ip', $ip, PDO::PARAM_INT);
			$stmt2->bindParam(':city', $city, PDO::PARAM_STR); 
			$stmt2->bindParam(':country', $country, PDO::PARAM_STR);
			$stmt2->bindParam(':count_open', $count_open, PDO::PARAM_INT);
			$stmt2->bindParam(':device_info', $device_info, PDO::PARAM_STR);
			$stmt2->bindParam(':date_sent', $date_sent, PDO::PARAM_STR);
			$stmt2->bindParam(':first_opened', date("Y-m-d h:i:sa"), PDO::PARAM_STR);
			/*** execute the prepared statement ***/
			$stmt2->execute();
        }
		
		
		else
		{
			$stmt3 = $dbh->prepare("UPDATE email_log set count_open = count_open + :count_open, last_opened = :last_opened, ip =:ip, device_info =:device_info WHERE subject =:subject and email_address =:email_address");
			$stmt3->bindParam(':count_open', $count_open, PDO::PARAM_INT);
			$stmt3->bindParam(':last_opened', date("Y-m-d h:i:sa") , PDO::PARAM_STR);
			$stmt3->bindParam(':subject', $subject, PDO::PARAM_STR);
			$stmt3->bindParam(':ip', $ip, PDO::PARAM_INT);
			$stmt3->bindParam(':email_address', $email_address, PDO::PARAM_STR); 
			$stmt3->bindParam(':device_info', $device_info, PDO::PARAM_STR);
			
			$stmt3->execute();
			
		}
		
    
    $graphic_http = THIS_WEBSITE_URI .'/blank.gif';
    $filesize = filesize( THIS_ABSOLUTE_PATH . '/blank.gif' );
    header( 'Pragma: public' );
    header( 'Expires: 0' );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Cache-Control: private',false );
    header( 'Content-Disposition: attachment; filename="blank.gif"' );
    header( 'Content-Transfer-Encoding: binary' );
    header( 'Content-Length: '.$filesize );
    readfile( $graphic_http );
    exit;
}

else
	header( 'Location: '.$_SERVER['SERVER_NAME'].'' );