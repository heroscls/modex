<?php

require "../vendor/autoload.php";

// Import do namespace Dompdf
use Dompdf\Dompdf;

// instanciação e uso da classe dompdf
$dompdf = new Dompdf();

// Liga o buffer de saída
ob_start();
// Carrega o arquivo que gera o HTML
require "conteudo-pdf.php";
// Pega tudo que estava no buffer (o HTML gerado) e limpa o buffer.
$html = ob_get_clean();

// Envia o HTML para o Dompdf processar.
$dompdf->loadHtml($html);

// (Opcional) Configuração do tamanho do papel
$dompdf->setPaper('A4');

try {
	// Renderização do HTML para PDF
	$dompdf->render();
	$filename = 'Relatorio-produtos-' . date('dmY') . '.pdf';
	$dompdf->stream($filename, ['Attachment' => 1]);
} catch (Exception $e) {
	$msg = $e->getMessage();
	if (stripos($msg, 'PHP GD extension') !== false || !extension_loaded('gd')) {
		http_response_code(500);
		echo "<h2>Erro ao gerar o relatório (GD não instalado)</h2>";
		echo "<p>O gerador de PDF necessita da extensão <strong>GD</strong> do PHP para processar imagens.</p>";
		echo "<p>Para resolver no XAMPP Windows: edite o arquivo <code>php.ini</code>, descomente (remova o ponto-e-vírgula) a linha <code>extension=gd</code> ou <code>extension=gd2</code>, salve e reinicie o Apache.</p>";
		echo "<p>Alternativamente, você pode gerar o relatório sem imagens removendo tags &lt;img&gt; do arquivo <code>produtos/conteudo-pdf.php</code>.</p>";
		echo "<p>Mensagem interna: " . htmlspecialchars($msg) . "</p>";
		exit;
	}
	throw $e;
}
// $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);


// Saída do PDF gerado para o Browser ou download
// $dompdf->stream();
// Attachment => 1 força o download. Se fosse 0 abriria no navegador.
$dompdf->stream($filename, ['Attachment' => 1]);