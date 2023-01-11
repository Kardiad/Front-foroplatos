const buttons = document.querySelectorAll('button');
let forms = document.getElementById('cambiar-form');
let tables = document.querySelectorAll('table');
if(tables.length>0){
    tables.forEach(e=>{
        if(e.getAttribute('id')!=null){
            $('#'+e.getAttribute('id')).DataTable();
        }
    });
}
//Eventos de los diversos botones de la página
buttons.forEach(e=>{
    e.addEventListener('click', ()=>{
        document.getElementById('exampleModalLabel').innerHTML = e.outerText;
        if(e.outerText==='Sign-in'){
            forms.innerHTML=`
            <form action="${url}/Index.php/registro" method="post">
                <input type="text" name="username" placeholder="nombre usuario">
                <input type="password" name="pass" placeholder="contraseña" id="pass">
                <input type="text" name="alias" placeholder="alias">
                <input type="text" name="nombre" placeholder="nombre">
                <input type="text" name="apellidos" placeholder="apellidos">
                <input type="text" name="edad" placeholder="edad">
                <input type="text" name="telefono" placeholder="telefono">
                <input type="mail" name="email" placeholder="email@email.com">
                <input type="submit" class="btn btn-success" value="enviar">
            </form>
            `;
        }
        if(e.outerText==='Log-in'){
            forms.innerHTML=`
            <form action="${url}/Index.php/usuario" method="post">
                <input type="text" name="username" placeholder="nombre usuario">
                <input type="password" name="pass" placeholder="contraseña" id="pass">
                <input type="submit" class="btn btn-success" value="enviar">
            </form>
            `;
        }
        if(e.outerText==='Log-off'){
            (async()=>{
                const conn = await fetch(url+'Index.php/logout');
                const res = await conn.json();
                if(res.status=='loggedout'){
                    window.location.href = url;
                }else{
                    toastr.error('Have fun storming the castle!', 'Miracle Max Says')
                }
            })();
        }
        if(e.outerText==='Datos'){
            (async()=>{
                const conn = await fetch(url+'Index.php/userdata');
                const res = await conn.json(); 
                forms.innerHTML=`
                <form action="${url}/Index.php/update" method="post">
                    <input type="text" name="username" placeholder="nombre usuario" value="${res.nombre_usuario}" disabled>
                    <input id="pass" type="password" name="pass" placeholder="contraseña" id="pass">
                    <input type="text" name="alias" placeholder="alias" value="${res.alias}" ${res.alias===''?'disabled':''}>
                    <input type="text" name="nombre" placeholder="nombre" value="${res.nombre}" ${res.nombre===''?'disabled':''}>
                    <input type="text" name="apellidos" placeholder="apellidos" value="${res.apellidos}" ${res.apellidos===''?'disabled':''}>
                    <input type="text" name="edad" placeholder="edad" value="${res.edad}" ${res.edad===''?'disabled':''}>
                    <input type="text" name="telefono" placeholder="telefono" value="${res.telefono}" ${res.telefono===''?'disabled':''}>
                    <input type="mail" name="email" placeholder="email@email.com" value="${res.correo}" ${res.correo===''?'disabled':''}>
                    <input type="submit" class="btn btn-success" value="enviar">
                </form>
                `;
            })();
        }
        if(e.outerText==='Baja'){
            forms.innerHTML=`
            <h2>Aviso darás de baja a tu cuenta y no podrás acceder nunca más, ni hablar con administradores para recuperar la cuenta</h2>
            <form action="${url}/Index.php/baja" method="post">
                <input type="password" name="password" placeholder="contraseña" id="pass">
                <input type="submit" class="btn btn-success" value="enviar">
            </form>
            `; 
        }
        if(e.outerText==='Crear Admin'){
            forms.innerHTML=`
            <form action="${url}/Index.php/admingen" method="post">
                <input type="text" name="username" placeholder="nombre usuario">
                <input type="password" name="password" placeholder="contraseña" id="pass">
                <input type="submit" class="btn btn-success" value="enviar">
            </form>
            `;
        }
        if(e.outerText==='Editar'){
            forms.innerHTML=`
            <form action="${url}/Index.php/recetaedit" method="post">
                <input type="text" name="username" placeholder="nombre usuario">
                <input type="password" name="password" placeholder="contraseña" id="pass">
                <input type="submit" class="btn btn-success" value="enviar">
            </form>
            `;
        }
        if(e.outerText==='Leer'){
            forms.innerHTML=`
            <form action="${url}/Index.php/leido" method="post">
                <input type="hidden" name="id" value="${e.attributes[2].textContent}">
                <p>${e.attributes[1].textContent}</p>
                <input type="submit" class="btn btn-success" value="marcar como leído">
            </form>           
            `;
        }
        if(e.outerText==='Eliminar Mensaje'){
            forms.innerHTML=`
            <form action="${url}/Index.php/borrarmensaje" method="post">
                <input type="hidden" name="id" value="${e.attributes[2].textContent}">
                <p>¿Estás seguro que quieres borrar el mensaje?</p>
                <input type="submit" class="btn btn-danger" value="${e.outerText}">
            </form>           
            `;
        }
        if(e.outerText==='Eliminar Receta'){
            forms.innerHTML=`
            <form action="${url}/Index.php/recetaborrar" method="post">
                <input type="hidden" name="id" value="${e.attributes[1].textContent}">
                <p>¿Estás seguro que quieres borrar la receta?</p>
                <input type="submit" class="btn btn-danger" value="${e.outerText}">
            </form>           
            `;
        }
        if(e.outerText==='Editar Receta'){
            forms.innerHTML=`
            <form action="${url}/Index.php/recetaedit" method="post">
            <input type="hidden" name="id" value="${e.attributes[1].textContent}">
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
            `;
        }
        if(e.outerText==='Eliminar administrador'){
            forms.innerHTML=`
            <form action="${url}/Index.php/borraradmin" method="post">
                <input type="hidden" name="id" value="${e.attributes[1].textContent}">
                <p>¿Estás seguro que quieres borrar a este Administrador?</p>
                <input type="submit" class="btn btn-danger" value="${e.outerText}">
            </form>           
            `;
        }
        if(e.outerText==='Eliminar Usuario'){
            forms.innerHTML=`
            <form action="${url}/Index.php/borrarusuario" method="post">
                <input type="hidden" name="id" value="${e.attributes[1].textContent}">
                <p>¿Estás seguro que quieres borrar al Usuario?</p>
                <input type="submit" class="btn btn-danger" value="${e.outerText}">
            </form>           
            `;
        }
        if(e.outerText==='Ver Receta'){
            (async()=>{
                const form = new FormData();
                form.append('id', e.attributes[1].textContent);
                const conn = await fetch(url+'Index.php/getReceta', {
                    method: 'POST',
                    body: form
                });
                const res = await conn.json();
                const receta = res.results.receta[0];
                forms.innerHTML = `
                    <div>
                        <h2>${receta.titulo}</h2>
                    </div>
                    <div>
                        <img src="data:${receta.formato};base64,${receta.foto}" style="width:100%;">
                    </div>
                    <div>
                        <p>${receta.tipo} / ${receta.dificultad}</p>
                    </div>
                    <div>
                        <p>${receta.ingredientes}</p>
                    </div>
                    <div>
                        <p>${receta.pasos}</p>
                    </div>
                    <div>
                        <p>${receta.ingredientes}</p>
                    </div>
                `;
            })();
        }
        let pass = forms.children[0].children;
        console.log(pass);
    });
});
//logout a los 5 min de no hacer nada
let logout = null; //Id del setTimeout
const salir = ()=>{ //función que ejecuta el set timeout
    logout = window.setTimeout(async()=>{ //función asíncrona en el set timeout
        const formdata = new FormData(); // instancio para crear una clase formulario
        formdata.append('killsession', true); //añado los parámetros que van al index php
        const conn = await fetch(url, { 
            method: 'POST',
            body : formdata
        }); //hago post al servidor para hacer log out
        const res = await conn.json();  //mando json respuesta para redireccionar
        if(res.status=='loggedout'){  //si cumple condición hace redirección traas cerrar sessión
            window.location.href = url;
        }
    }, 300000); //300000 son 5min en milisegundos, set time out admite mayores cantidades de tiempos
}
//Eventos para manejar la actividad de la página
window.addEventListener('mousemove', (e)=>{
    window.clearTimeout(logout);
    salir();
});
window.addEventListener('keypress', (e)=>{
    window.clearTimeout(logout);
    salir();
})
