<?php
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
    <title>Desafio PHP | Detalhe do Produto</title>
</head>

<body class="bg-cinza">
    <main class="container">
        <div class="row mt-5">
            <a href="index.php"><button class="ml-3">&#x2190 Voltar para lista de produtos</button></a>
        </div>
        <div class="row mt-5">

            <!-- Verificando se existe algum id de produto sendo passado via GET -->
            <?php if(isset($_GET['id'])){ ?>

                <!-- Percorrendo array com foreach, mas com a condição de trazer os dados somente do produto que está sendo passado via GET -->
                <?php 
                foreach($produtos as $produto){
                    if($_GET["id"]==$produto["id"]){
                ?>
                <!-- Exibindo imagem do produto -->
                <div class="col-5">
                    <img src="<?php echo $produto["imgProduto"];?>" class="img-fluid" alt="Imagem produto">
                </div>
                <!-- Exibindo detalhes do produto -->
                <div class="col-7 pl-5">
                    <div class="row flex-column">
                        <h1><?php echo $produto["nomeProduto"];?></h1>
                        <p class="topico-produto">Categoria</p>
                        <h3 class="descricao-produto"><?php echo $produto["categoriaProduto"];?></h3>
                        <p class="topico-produto">Descrição</p>
                        <h3 class="descricao-produto"><?php echo $produto["descricaoProduto"];?></h3>
                    </div>
                    <div class="row">
                        <div class="col-6 pl-0">
                            <p class="topico-produto">Quantidade em estoque</p>
                            <h3 class="descricao-produto"><?php echo $produto["quantidadeProduto"];?></h3>
                        </div>
                        <div class="col-6 pl-0">
                            <p class="topico-produto">Preço</p>
                            <h3 class="descricao-produto-preco">R$ <?php echo $produto["precoProduto"];?></h3>
                        </div>
                    </div>
                </div>
                <!-- Fechando if -->
                <?php } ?>
                <!-- Fechando foreach -->
                <?php } ?>
            <!-- Else do "if isset GET" -->
            <?php }else{?>
            <h2>Nenhum produto foi selecionado.</h2>
            <!-- Fechando else -->
            <?php } ?>

        </div>
    </main>
</body>

</html>