<?php
  include("ModelCadastro.php");
  include("ModelLogin.php");
  include("ModelAtualizar.php");
  include("ModelDeletar.php");
  include("Usuario.php");
  include("Paciente.php");
  include("Medico.php");

  class CadastroController {
    private $cadastroModel;
    private $loginModel;
    private $atualizacaoModel;
    private $delecaoModel;

    public function __construct() {
      // Inicializa os modelos correspondentes
      $this->cadastroModel = new Cadastro();
      $this->loginModel = new Login();
      $this->atualizacaoModel = new Atualizacao();
      $this->delecaoModel = new Delecao();
    }

    public function processarRequisicao() {
      $acao = filter_input(INPUT_GET, "acao");

      switch ($acao) {
        case "cadastrar":
          $this->cadastrar();
          break;
        case "login":
          $this->login();
          break;
        case "atualizar":
          $this->atualizar();
          break;
        case "deletar":
          $this->deletar();
          break;
        default:
          echo "Ação inválida.";
      }
    }

    private function cadastrar() {
      $nome  = filter_input(INPUT_GET, "nome");
      $email = filter_input(INPUT_GET, "email");
      $senha = filter_input(INPUT_GET, "senha");
      $tipo  = filter_input(INPUT_GET, "tipo");

      $usuario = new Usuario();
      $usuario->setNome($nome);
      $usuario->setEmail($email);
      $usuario->setSenha($senha);
      $usuario->setTipo($tipo);

      if ($tipo === "paciente") {
          $cpf      = filter_input(INPUT_GET, "cpf");
          $dataNasc = filter_input(INPUT_GET, "data_nasc");
          $telefone = filter_input(INPUT_GET, "telefone");

          $paciente = new Paciente();
          $paciente->setCpf($cpf);
          $paciente->setDataNasc($dataNasc);
          $paciente->setTelefone($telefone);

          $this->cadastroModel->cadastrar($usuario, $paciente);
      } else if ($tipo === "medico") {
          $cpf           = filter_input(INPUT_GET, "cpf");
          $crm           = filter_input(INPUT_GET, "crm");
          $especialidade = filter_input(INPUT_GET, "especialidade");
          $telefone      = filter_input(INPUT_GET, "telefone");

          $medico = new Medico();
          $medico->setCpf($cpf);
          $medico->setCrm($crm);
          $medico->setEspecialidade($especialidade);
          $medico->setTelefone($telefone);

          $this->cadastroModel->cadastrar($usuario, $medico);
      } else {
          echo "Tipo de usuário inválido. Informe 'paciente' ou 'medico'.";
      }
    }

    private function login() {
      $email = filter_input(INPUT_GET, "email");
      $senha = filter_input(INPUT_GET, "senha");

      $usuario = json_decode($this->loginModel->login($email, $senha), true);

      if (isset($usuario['id'])) {
        echo "Login realizado com sucesso. Usuário: " . $usuario["nome"];
      } else {
        echo "E-mail ou senha inválidos.";
      }
    }

    private function atualizar() {
      $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
      $nome  = filter_input(INPUT_GET, "nome");
      $email = filter_input(INPUT_GET, "email");
      $senha = filter_input(INPUT_GET, "senha");

      $usuario = new Usuario();
      $usuario->setId($id);
      $usuario->setNome($nome);
      $usuario->setEmail($email);
      $usuario->setSenha($senha);

      $tipo = filter_input(INPUT_GET, "tipo");

      if ($tipo === "paciente") {
        $cpf      = filter_input(INPUT_GET, "cpf");
        $dataNasc = filter_input(INPUT_GET, "data_nasc");
        $telefone = filter_input(INPUT_GET, "telefone");

        $paciente = new Paciente();
        $paciente->setCpf($cpf);
        $paciente->setDataNasc($dataNasc);
        $paciente->setTelefone($telefone);

        $this->atualizacaoModel->atualizar($usuario, $paciente);
      } else if ($tipo === "medico") {
        $cpf           = filter_input(INPUT_GET, "cpf");
        $crm           = filter_input(INPUT_GET, "crm");
        $especialidade = filter_input(INPUT_GET, "especialidade");
        $telefone      = filter_input(INPUT_GET, "telefone");

        $medico = new Medico();
        $medico->setCpf($cpf);
        $medico->setCrm($crm);
        $medico->setEspecialidade($especialidade);
        $medico->setTelefone($telefone);

        $this->atualizacaoModel->atualizar($usuario, $medico);
      } else {
        echo "Tipo de usuário inválido.";
      }
    }

    private function deletar() {
      $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
      
      if ($id) {
        $usuario = new Usuario();
        $usuario->setId($id);

        echo $this->delecaoModel->deletar($usuario);
      } else {
        echo "ID inválido.";
      }
    }
  }

  // Inicializa o controlador e processa a requisição
  $controller = new CadastroController();
  $controller->processarRequisicao();
?>
