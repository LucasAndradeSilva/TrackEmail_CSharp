<?php
    require("conexao.php");
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");

    Class Acesso{
        private $con  = null;
        private $mail = null;

        public function __construct($conexao){
            $this->con = $conexao;

            $this->mail = new PHPMailer/PHPMailer();
            $this->mail->isSMTP();

            $this->mail->Port = "465";
            $this->mail->Host = "smtp.gmail.com";
            $this->mail->IsHTML(true);
            $this->mail->SMTPSecure = "ssl";
            $this->mail->Mailer = "smtp";
            $this->mail->CharSet = "UTF-8";

            $this->mail->SMTPAuth = true;
            $this->mail->Username = "SeuEnderecoDeEmail@gmail.com";
            $this->mail->Password = "SuaSenha";
            $this->mail->SingleTo = true;

            $this->mail->From = "SeuEnderecoDeEmail@gmail.com";
            $this->mail->FromName = "Equipe Sistema de Acesso";
        }

        public function send(){
            if(empty($_POST) || $this->con == null){
                echo json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro interno no servidor."));
                return;
            }

            switch(true){
                case (isset($_POST["type"]) && $_POST["type"] == "login" && isset($_POST["email"]) && isset($_POST["senha"])):
                    echo $this->login($_POST["email"], $_POST["senha"]);
                    break;

                case (isset($_POST["type"]) && $_POST["type"] == "cadastro" && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["nome"])):
                    echo $this->cadastro($_POST["email"], $_POST["senha"], $_POST["nome"]);
                    break;
            }
        }

        public function login($email, $senha){
            $conexao = $this->con;

            $query = $conexao->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
            $query->execute(array($email, $senha));

            if($query->rowCount()){
                $user = $query->fetchAll(PDO::FETCH_ASSOC)[0];

                session_start();
                $_SESSION["usuario"] = array($user["nome"], $user["adm"]);

                return json_encode(array("erro" => 0));
            }else{
                return json_encode(array("erro" => 1, "mensagem" => "Email e/ou senha incorretos."));
            }
        }

        public function cadastro($email, $senha, $nome){
            $conexao = $this->con;

            $query = $conexao->prepare("INSERT INTO usuarios (email, senha, nome, adm, confirmado) VALUES (?, ?, ?, ?, ?)");
            
            if($query->execute(array($email, $senha, $nome, 0, 0))){
                session_start();
                $_SESSION["usuario"] = array($nome, 0);

                $this->mail->addAddress($email);
                $this->mail->Subject = "Confirmação do endereço de email";
                $this->mail->Body = "<h1>Olá {$nome}, bem vindo ao Sistema de Acesso</h1>Clique no link para confirmar seu email:<br><a href='http://localhost/login/acoes/confirmarEmail.php?email={$email}'>Confirmar email</a>";

                if(!$this->mail->send()){
                    echo $this->mail->ErrorInfo;
                }
                
                return json_encode(array("erro" => 0));
            }else{
                return json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro ao cadastrar usuario."));
            }
        }
    };

    $conexao = new Conexao();
    $classe  = new Acesso($conexao->conectar());
    $classe->send();
?>
