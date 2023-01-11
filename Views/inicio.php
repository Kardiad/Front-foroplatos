<!--antes se pondrá un if para validar que tipo de ventana le toca por usuarios-->
<main id="recetario">
    <!--Lugar donde va a ir el mayor foreach de la historia o for-->
    <?php
    if(!$data['admin']):?>
    <?php
    unset($data['admin']); 
    foreach($data as $recetas):?>
        <?php if($recetas->status==200):?>
        <section id="recetas<?=$recetas->results->receta[0]->id?>" class="recetas">
            <div class="contenedor-recetas">
                <div>
                    <h2>
                        <?=$recetas->results->receta[0]->titulo?>
                    </h2>
                </div>
                <div>
                    <?php if($recetas->results->receta[0]->foto==null):?>
                        <div class="imagen">
                        </div>
                    <?php else:?>
                        <div class="imagen">
                            <img src="data:<?=$recetas->results->receta[0]->formato?>;base64,<?php echo $recetas->results->receta[0]->foto;?>">
                        </div>
                    <?php endif;?>
                </div>
                <div id="receta" class="receta">
                    <h2>Receta</h2>
                    <div style="text-align: center;">
                        <p>Detalles</p>
                        <small>Tipo: <?=$recetas->results->receta[0]->tipo?></small>
                        <small>Dificultad: <?=$recetas->results->receta[0]->dificultad?></small>
                    </div>
                    <h3>Ingredientes</h3>
                    <p><?=$recetas->results->receta[0]->ingredientes?></p>
                    <h3>Pasos</h3>
                    <p><?=$recetas->results->receta[0]->pasos?></p>
                </div>
                <div id="comentarios" class="comentarios">
                    <?php if(!isset($recetas->results->comentarios->status)):?>
                    <h3>Comentarios</h3>
                    <?php foreach($recetas->results->comentarios as $comentarios):?>
                        <p>
                            <b><?=$comentarios->alias?></b><small> valoracion - <?=$comentarios->valoracion?>/5</small>
                            <?=$comentarios->comentario?>
                        </p>
                    </div>
                <?php endforeach;?>
                <?php else:?>
                    <p>No hay comentarios, sé el primero, registrate o logueate para comentar</p>
                <?php endif;?>
                <?php if(!empty($_SESSION[session_id()])):?>
                <div id="comentar" class="comentar">
                    <h3>Escribe tu valoración</h3>
                    <form action="<?=HTTP?>/Index.php/comentar" method="POST">
                        <div>
                            <input type="hidden" name="id_receta" value="<?=$recetas->results->receta[0]->id?>">
                            <textarea name="comentario" id="comentario" data-id-comentario="<?=$recetas->results->receta[0]->id?>" style="resize:none;"></textarea>
                            <label for="valoracion">Introduce valoracion</label>
                            <input type="number" name="valoracion" id="valoracion" data-id-valoracion = "<?=$recetas->results->receta[0]->id?>" min="0" max="5">
                        </div>
                        <input type="submit" class="btn btn-success" data-id-receta="<?=$recetas->results->receta[0]->id?>" value="enviar">
                    </form>
                </div>
                <?php endif;?>
            <?php endif;?>
        </div>
    </section>
    <?php endforeach;?>
    <?php elseif($data['admin']):?>
       <!--aqui va el panel de administrador-->
       <section class="gestion-recetas">
            <div>
                <h2>Panel de recetas</h2>
            </div>
            <div>
                <div class="alta">
                    <h2>
                        Alta de receta
                    </h2>
                    <form action="<?=HTTP?>Index.php/nuevaReceta" method="post" enctype="multipart/form-data">
                        <input type="text" name="titulo" id="titulo" placeholder="titulo de receta">
                        <textarea name="ingredientes" id="ingredientes" cols="30" rows="10" placeholder="ingredientes" style="height:10vh;resize:none;margin-bottom:1rem"></textarea>
                        <textarea type="text" name="pasos" id="pasos" placeholder="pasos" style="height:25vh;resize:none;margin-bottom:1rem"></textarea>
                        <select name="dificultad" id="dificultad">
                            <option value="">introduce opcion</option>
                            <option value="facil">fácil</option>
                            <option value="intermedio">intermedio</option>
                            <option value="difícil">dificil</option>
                            <option value="maestro">maestro</option>
                        </select>
                        <input type="file" name="foto">
                        <p for="dificultad">Dificultad</p>
                        <select name="tipo" id="dificultad">
                            <option value="">introduce opcion</option>
                            <option value="Tradicional">Tradicional</option>
                            <option value="SlowFood">SlowFood</option>
                            <option value="difícil">dificil</option>
                            <option value="Freidora sin aceite">Freidora sin aceite</option>
                        </select>
                        <input type="submit" value="Enviar">
                    </form>
                </div>
                <div class="recetas">
                    <div>
                        <h2>
                            Recetas de nuestro foro
                        </h2>
                        <div>
                            <table id="tabla-recetas">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titiulo</th>
                                        <th>Dificultad</th>
                                        <th>Tipo</th>
                                        <th>Eliminar</th>
                                        <th>Editar</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['recetas']->results as $receta):?>
                                            <tr>
                                                <td><?=$receta->id?></td>
                                                <td><?=$receta->titulo?></td>
                                                <td><?=$receta->dificultad?></td>
                                                <td><?=$receta->tipo?></td>
                                                <td><button class="btn btn-danger" data-eliminar-receta="<?=$receta->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar Receta</button></td>
                                                <td><button class="btn btn-warning" data-update-receta="<?=$receta->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar Receta</button></td>
                                                <td><button class="btn btn-primary" data-ver-receta="<?=$receta->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Ver Receta</button></td>
                                            </tr>
                                        <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
       </section>
       <section class="gestion-usuarios">
            <h2>Panel de usuarios</h2>
            <div class="sub">
                    <div class="admin">
                        <h3>Administradores</h3>
                        <table id="tabla-admin">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Alta</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['usuarios']->results->admins as $admin):?>
                                <tr>
                                    <td><?=$admin->id?></td>
                                    <td><?=$admin->username?></td>
                                    <td><?=$admin->alta?></td>
                                    <td><button class="btn btn-danger" data-eliminar-admin="<?=$admin->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar administrador</button></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        <table>
                    </div>
                    <div class="usuarios">
                        <h3>Usuarios</h3>
                        <table id="tabla-usuarios">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Alias</th>
                                    <th>Tipo</th>
                                    <th>Apellidos</th>
                                    <th>Teléfono</th>
                                    <th>Edad</th>
                                    <th>Email</th>
                                    <th>Alta</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['usuarios']->results->usuarios as $usuarios):?>
                                <tr>
                                    <td><?=$usuarios->id?></td>
                                    <td><?=$usuarios->username?></td>
                                    <td><?=$usuarios->alias?></td>
                                    <td><?=$usuarios->nombre?></td>
                                    <td><?=$usuarios->apellidos?></td>
                                    <td><?=$usuarios->telefono?></td>
                                    <td><?=$usuarios->edad?></td>
                                    <td><?=$usuarios->email?></td>
                                    <td><?=$usuarios->alta?></td>
                                    <td><button class="btn btn-danger" data-eliminar-usuario="<?=$usuarios->username?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar Usuario</button></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Admin</button>
            </div>
       </section>
       <section class="gestion-mensajes">
            <h2>Panel de mensajes</h2>
            <div>
                <table  id="tabla-mensajes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['mensajes']->results as $mensajes):?>
                            <tr>
                                <td><?=$mensajes->id?></td>
                                <td><button class="btn btn-primary" data-mensaje-contenido="<?=$mensajes->texto?>" data-mensaje-id="<?=$mensajes->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Leer</button></td>
                                <td><?=$mensajes->estado?></td>    
                                <td><button class="btn btn-danger" data-mensaje-borrar="<?=$mensajes->id?>" data-mensaje-id="<?=$mensajes->id?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar Mensaje</button></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
       </section>
    <?php else:?>
        <h2>NO HAY CONTENIDO QUE MOSTRAR LOGUEATE Y AVISA AL ADMINISTRADOR</h2>
    <?php endif;?>
</main>