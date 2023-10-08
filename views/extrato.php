<?php
date_default_timezone_set("AMERICA/Sao_Paulo");
require_once "vendor/autoload.php";
$html = "<h1>Extrato da Compra - {date('d/m/y')}</h1>";
$html.= "<table>
            <tr>
                 <th>Produto</th>
                 <th>Quantidade</th>
                 <th>Preço</th>
            </tr>";
    foreach($_SESSION["carrinho"] as $dado)
    {
        $html .= "<tr>
                        <td>{$dado['nome']}</td>
                        <td>{$dado['quantidade']}</td>
                        <td>{$dado['preco']}</td>
                 </tr>";
    }
    $html .= "</table>";

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->AddPage("P");
    $estilo = file_get_contents("style/style.css");
    $mpdf->writeHTML($html);
    $mpdf->output();
?>
