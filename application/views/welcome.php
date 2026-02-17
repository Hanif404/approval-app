<?php
$page_title = '';
ob_start();
?>

<!-- <div class="card">
    <div class="card-header">
        <h3 class="card-title">Welcome to CodeIgniter</h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body">
		<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
	</div>
</div> -->

<style>
:root{--card-bg: rgba(255,255,255,0.98);--muted:#555}
.welcome-wrap{display:flex;align-items:center;justify-content:center;min-height:50vh;padding:2rem;box-sizing:border-box}
.welcome-inner{display:flex;gap:2rem;align-items:center;justify-content:center;width:100%;max-width:1100px}
.welcome-card{flex:1;max-width:640px;padding:2rem;background:var(--card-bg);border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.06);text-align:left}
.welcome-card h1{margin:0 0 .5rem;font-size:2rem}
.welcome-card p.lead{margin:0;color:var(--muted);line-height:1.4}
.lottie-column{flex:1;display:flex;align-items:center;justify-content:center}
#lottie-welcome{width:100%;max-width:520px;height:auto}
@media (max-width: 992px){
    .welcome-inner{flex-direction:column-reverse;padding-top:1rem}
    .welcome-card{background:transparent;box-shadow:none;padding:1rem;text-align:center}
}
@media (max-width:480px){
    .welcome-card h1{font-size:1.4rem}
    #lottie-welcome{max-width:360px}
}
</style>

<div class="welcome-wrap">
    <div class="welcome-inner">
        <div class="welcome-card">
            <h1>Welcome</h1>
            <p class="lead">Welcome to the approval app — quick links and summaries appear here.</p>
        </div>
        <div class="lottie-column">
            <div id="lottie-welcome" aria-hidden="true"></div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var container = document.getElementById('lottie-welcome');
    if (!container) return;
    lottie.loadAnimation({
        container: container,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '<?php echo base_url('asset/templates/adminlte/img/welcome-img.json'); ?>'
    });
});
</script>
<?php
$content = ob_get_clean();
$this->load->view('templates/layout', compact('title', 'page_title', 'content'));
?>

