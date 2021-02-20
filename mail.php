<?php
      
	  include("ayar.php");

	  if(isset($_POST['kaydet'])){
		  $isim = trim($_POST['isim']);
		  $sifre = trim($_POST['sifre']);
		  $email = trim($_POST['email']);
		  //veritabanında bir kod oluşturmalıyız üyelik işleminde onaylı/onaysız ayrımı için
		  $kod= md5(rand(0,9999));

		  if(!$isim || !$sifre ||!$email ){
			  echo "Lütfen Tüm alanları doldurun";

		  }else{
			$insert = $db->prepare("insert into uyeler set 
			  
			uye_adi=?,
			uye_sifre=?,
			uye_eposta=?,
			uye_kod=?

");			   

$ok = $insert->execute(array($isim,$sifre,$email,$kod));  
		 
			
			if($ok){
				 
				include("mail/PHPMailerAutoload.php");
				$mail = new PHPMailer;            
 			
			$mail->IsSMTP();
			//$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls'; // G�venli baglanti icin ssl normal baglanti icin tls
			$mail->Host = "smtp.gmail.com"; // Mail sunucusuna ismi
			$mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
			$mail->IsHTML(true);
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->CharSet  ="utf-8";
			$mail->Username = "deneme@gmail.com"; // Mail adresimizin kullanic� adi
			$mail->Password = "xxxxxxx"; // Mail adresimizin sifresi
			$mail->SetFrom("deneme@gmail.com",$isim); // Mail attigimizda gorulecek ismimiz
			$mail->AddAddress("$email"); // Maili gonderecegimiz kisi yani alici
			$mail->addReplyTo($email, $isim);
			$mail->Subject = "Üye onay maili Deneme PHP sitesi"; // Konu basligi
			$mail->Body = "<div style='background:#eee;padding:5px;margin:5px;width:300px;'> eposta : ".$email."</div> <br /> mesaj : <br />
			http://localhost/onay.php?email=".$email."&$kod=".$kod."";
			// Mailin icerigi
			if(!$mail->Send()){
			
                  echo 'mail gonderilemedi';
			
			}else {
				
				echo 'mail gonderildi...';
				
			}
			}else{
				echo "mail içine girmiyor hata oluştu";
			}

		  }}
		   
			
            
				
				?>