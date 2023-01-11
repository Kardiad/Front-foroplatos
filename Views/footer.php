<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="cambiar-form">
        
      </div>
    </div>
  </div>
</div>
<?php if(!$data['admin']):?>
<footer>
    <?php if(!empty($_SESSION[session_id()]) && !$data['admin']):?>
        <div class="tittle">
            <h1>Envía una sugerencia a nuestros admins</h1>
            <p><small>Sólo válido para usuarios registrados</small></p>
        </div>
        <form action="<?=HTTP?>/Index.php/mensaje" method="post" class="mandar-cosas">
            <textarea name="texto" id="comentario_admin" cols="30" rows="10">

            </textarea>
            <input type="submit" value="enviar">
        </form>
    <?php elseif($data['admin']):?>
        <div>
            <h1>Es tu día sé feliz</h1>
        </div>
    <?php else:?>
        <div>
            <h1>Logeate para poder contactar con nuestros admin y hacer sugerencias a la página</h1>
        </div>
    <?php endif;?>
</footer>
<?php endif;?>
<script>
    const url = "<?=HTTP?>";
</script>
<script src="<?=HTTPPUBLIC?>/js/app.js"></script>
</body>
</html>