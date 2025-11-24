<?php
require "../vendor/autoload.php";
use Dompdf\Dompdf;

$dompdf = new Dompdf();
ob_start();
require "conteudo-pdf.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
try {
	$dompdf->render();
	$filename = 'Relatorio-avaliacoes-' . date('dmY') . '.pdf';
	$dompdf->stream($filename, ['Attachment' => 1]);
} catch (Exception $e) {
	$msg = $e->getMessage();
	if (stripos($msg, 'PHP GD extension') !== false || !extension_loaded('gd')) {
		http_response_code(500);
		echo "<h2>Erro ao gerar o relatório (GD não instalado)</h2>";
		echo "<p>O gerador de PDF necessita da extensão <strong>GD</strong> do PHP para processar imagens.</p>";
		echo "<p>Para resolver no XAMPP Windows: edite o arquivo <code>php.ini</code>, descomente (remova o ponto-e-vírgula) a linha <code>extension=gd</code> ou <code>extension=gd2</code>, salve e reinicie o Apache.</p>";
		echo "<p>Alternativamente, você pode gerar o relatório sem imagens removendo tags &lt;img&gt; do arquivo <code>avaliacoes/conteudo-pdf.php</code>.</p>";
		echo "<p>Mensagem interna: " . htmlspecialchars($msg) . "</p>";
		exit;
	}
	throw $e;
}
