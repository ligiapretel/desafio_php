<?php

    function cadastrarProduto($nomeProduto,$categoriaProduto,$descricaoProduto,$quantidadeProduto,$precoProduto,$imgProduto){

    $nomeArquivo = "produtos.json";
    // Verificando se o arquivo existe.
    if(file_exists($nomeArquivo)){
       // Abrindo e pegando informações do arquivo json.
       $arquivo = file_get_contents($nomeArquivo);
       // Transformar o json em array (decode).
       $produtos = json_decode($arquivo,true);

            // Verificando se o arquivo, apesar de existir, está vazio.
            if($produtos==[]){

            // Adicionando novo produto na estrutura do array associativo. Se não existir produto, o id inicia em 1.
            $produtos[] = ["id"=>1,"nomeProduto"=>$nomeProduto, "categoriaProduto"=>$categoriaProduto, "descricaoProduto"=>$descricaoProduto, "quantidadeProduto"=>$quantidadeProduto, "precoProduto"=>$precoProduto, "imgProduto"=>$imgProduto];

                //Fechando if e abrindo else (caso o arquivo não esteja vazio, o id do produto será dinâmico e deve somar 1 ao último id cadastrado.
                }else{
                    // Função para percorrer o último produto do array associativo.
                    $ultimoProduto = end($produtos);
                    // Somando 1 ao último id encontrado.
                    $incrementandoId = $ultimoProduto["id"] + 1;

                    // var_dump($incrementandoId);
                    // exit;
                    // Na etiqueta id, coloco a variável que soma 1 a última posição.
                    $produtos[] = ["id"=>$incrementandoId,"nomeProduto"=>$nomeProduto, "categoriaProduto"=>$categoriaProduto, "descricaoProduto"=>$descricaoProduto, "quantidadeProduto"=>$quantidadeProduto, "precoProduto"=>$precoProduto, "imgProduto"=>$imgProduto];
                }

       // Colocando arquivo alterado em formato json
       $json = json_encode($produtos);
       // Salvando os arquivos no produtos.json. Estrutura - primeiro nome do arquivo, depois o encode (variável que faz o encode).
       $deuCerto = file_put_contents($nomeArquivo,$json);

    }else{
        // Aqui declaramos a estrutura do array, vazio ainda, para depois adicionar elementos dentro dele (é possível já fazer tudo em uma linha, então ficaria: $produtos = [["nome"=>$nomeProduto, "preco"=>$precoProduto, "img"=>$imgProduto, "descricao"=>$descricaoProduto]];)
        $produtos = [];
        //faz o mesmo que array_push:
        // o nome da etiqueta tem que ser o mesmo que chamo lá no form; o nome da variável é a mesma definida na function
        $produtos[] = ["id"=>1,"nomeProduto"=>$nomeProduto, "categoriaProduto"=>$categoriaProduto, "descricaoProduto"=>$descricaoProduto, "quantidadeProduto"=>$quantidadeProduto, "precoProduto"=>$precoProduto, "imgProduto"=>$imgProduto];
        // Tranformando o array associativo em json.
        $json = json_encode($produtos);
        // Salvando os arquivos no produtos.json.
        $deuCerto = file_put_contents($nomeArquivo,$json);

    }
}

//verificando se tem algo sendo enviado via post
if($_POST){
    // Salvando arquivo - dentro do files tem que ter o name que vai no input do form, e depois o dado específico que quero pegar dentro desse array (para visualizar esse dado, damos var_dump na $_FILES).
    $nomeImagem = $_FILES["imgProduto"]["name"];
    $localTempImagem = $_FILES["imgProduto"]["tmp_name"];
    //pegando a data atual para concatenar ao nome da imagem
    $dataAtual = date("d-m-y");
    // Onde eu quero que esse arquivo seja salvo:
    $caminhoImagem = "img/".$dataAtual.$nomeImagem;

    $tudoOk = move_uploaded_file($localTempImagem,$caminhoImagem);
    //colocar parâmetros na mesma ordem que defini na função:
    //o nome que vai dentro do post é o mesmo "name" que está no form.
    // Esse echo imprime o retorno da função.
    echo cadastrarProduto($_POST["nomeProduto"], $_POST["categoriaProduto"], $_POST["descricaoProduto"], $_POST["quantidadeProduto"], $_POST["precoProduto"], $caminhoImagem);
}

    // Para que os produtos após cadastrados no form sejam exibidos na mesma tela, preciso deixar as variáveis abaixo depois da função.
    $nomeArquivo = "produtos.json";
    // Abrindo e já transformando o arquivo json em array associativo
    $produtos = json_decode(file_get_contents($nomeArquivo),true);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet" />
    <title>Desafio PHP | Cadastro de Produto</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <!-- Tabela que exibe os produtos cadastrados -->
            <div class="col-7 pt-5 pr-5">
                <h1>Todos os produtos</h1>
                <table class="table">
                    <?php if(isset($produtos) && $produtos != []){?>
                    <thead class="thead-light">
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($produtos as $produto){
                        ?>
                        <tr>
                            <th><a
                                    href="detalheProduto.php?id=<?php echo $produto["id"];?>"><?php echo $produto["nomeProduto"];?></a>
                            </th>
                            <td><?php echo $produto["categoriaProduto"];?></td>
                            <td>R$ <?php echo $produto["precoProduto"];?></td>
                        </tr>
                        <!-- Fechando foreach -->
                        <?php } ?>
                        <!-- Fechando if(isset) -->
                        <?php } else { ?>
                        <h4>Ops! Não temos produtos cadastrados no momento.</h4>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Formulário para cadastrar produtos -->
            <div class="col-5 bg-light p-5 mt-5">
                <div class="col-12">
                    <h2>Cadastrar produto</h2>
                </div>
                <div class="col-12 mt-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="font-weight-bold" for="nomeId">Nome</label>
                            <input class="form-control" type="text" name="nomeProduto" id="nomeId" required />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="categoriaId">Categoria</label>
                            <select class="form-control" name="categoriaProduto" id="categoriaId" required>
                                <option disabled selected>Selecione a categoria</option>
                                <option value="bermuda">Bermuda</option>
                                <option value="camiseta">Camiseta</option>
                                <option value="conjunto">Conjunto</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="descricaoId">Descrição</label>
                            <textarea class="form-control" name="descricaoProduto" id="descricaoId" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="quantidadeId">Quantidade</label>
                            <input class="form-control" type="number" name="quantidadeProduto" id="quantidadeId"
                                required />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="precoId">Preço</label>
                            <input class="form-control" type="number" step="0.01" name="precoProduto" id="precoId"
                                required />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="imgId">Foto do produto</label>
                            <input type="file" name="imgProduto" id="imgId" />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>