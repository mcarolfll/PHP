# PHP
Funciona em **conjunto com HTML**, mas o **código PHP é executado no servidor**, e o que chega ao navegador do usuário é **apenas o HTML gerado**.

### Onde o PHP roda?

**XAMPP** , **MAMP** ou **LARAGON**

Como iniciar:

```php
<?php → Diz onde o código PHP começa.
echo → É usado para mostrar algo na tela.
```

Exemplo: 

```php
<?php
echo "Olá, mundo";
?>
```

### Variaveis no php:

Variavel inteira e operação matemática: 

```php
<?php
$idade = 25;
$ano_futuro = $idade + 5;
echo $ano_futuro;
?>
```

variável float:

```php
<?php
$altura = 1.65;
echo "Altura: " . $altura . "m";
?>
```

Variavel booleana (verdadeiro ou falso):

```php
<?php
$tem_carteira = true;
if($tem_carteira){
echo "Pode dirigir";        
} else {
echo "Não pode dirigir";
}
?>
```

Concatenando variáveis com ( . ):

```php
<?php
$nome = "João";
$sobrenome = "Silva";
echo "Nome Completo": $nome  .  $sobrenome;
?>

```

[Sistema Cadastro](https://www.notion.so/Sistema-Cadastro-1f9c902c79758008b17be9b7920138df?pvs=21)
