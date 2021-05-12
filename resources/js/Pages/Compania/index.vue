<template>
    <pantalla
        ref="pantalla"
        :menus="menus"
        :data="companias"
        :header="header"
        icono="<span class='mif-home'></span>"
        linkStore="compania.store"
        linkUpdate="compania.update"
        linkDelete="compania.destroy"
        linkBack="compania.index"
        :convertRecord="transformar"
        titulo="Compañias"
    >
        <template v-slot:default="parent">
            <div class="row mb-2 d-flex flex-align-center">
                <label class="cell-3">Ruc</label>
                <div class="cell-9">
                    <input type="text" v-model="parent.form.ruc" class="metro-input" >
                </div>
            </div>
            <div class="row mb-2 d-flex flex-align-center">
                <label class="cell-3">Razón Social</label>
                <div class="cell-9">
                    <input type="text" v-model="parent.form.razon_social" class="metro-input" >
                </div>
            </div>

            <div data-role="panel" data-title-caption="Config. SMTP" data-collapsible="true" class="mb-4">
                <label class="cell-12">SMTP Server</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.smtpServer" class="metro-input" >
                </div>
                <label class="cell-12">SMTP Puerto</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.smtpPuerto" class="metro-input" >
                </div>
                <label class="cell-12">SMTP Usuario</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.smtpUsuario" class="metro-input" >
                </div>
                <label class="cell-12">SMTP Clave</label>
                <div class="cell-12">
                    <input type="password" v-model="parent.form.smtpClave" class="metro-input" >
                </div>
            </div>

            <div data-role="panel" data-title-caption="Config. Directorios" data-collapsible="true" class="mb-4">
                <label class="cell-12">Directorio Extraccion</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.dirExtraccion" class="metro-input" >
                </div>
                <label class="cell-12">Directorio Leido</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.dirLeido" class="metro-input" >
                </div>
                <label class="cell-12">Fichero Separador de Linea</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.sepLinea" class="metro-input" >
                </div>
                <label class="cell-12">Fichero Separador de Columnas</label>
                <div class="cell-12">
                    <input type="text" v-model="parent.form.sepColumna" class="metro-input" >
                </div>
            </div>

        </template>
    </pantalla>
</template>
<script>
import Pantalla from '../../controles/pantalla';
export default{
    props:["companias","menus"],
    components:{
        'pantalla': Pantalla
    },
    mounted()
    {
        this.$refs.pantalla.showForm('B');
    },
    data(){
        return{
            accion:"B",
            header:[
                {label: "Id", campo: "id"},
                {label: "Ruc", campo: "ruc"},
                {label: "Razón Social", campo: "razon_social"},                
                {label: "Estado", campo: "estado"}                
            ]

        }
    },
    methods:{
        transformar(registro,modo)
        {
            var record = {};

            record.id = registro.id;
            record.ruc = registro.ruc;
            record.razon_social = registro.razon_social;
            if(modo == "STORE")
            {
                record.smtp = JSON.stringify( {
                    smtpServer : registro.smtpServer,
                    smtpPuerto : registro.smtpPuerto,
                    smtpUsuario : registro.smtpUsuario,
                    smtpClave : registro.smtpClave
                });
                record.config = JSON.stringify({
                    dirExtraccion : registro.dirExtraccion,
                    dirLeido : registro.dirLeido,
                    sepLinea : registro.sepLinea,
                    sepColumna : registro.sepColumna
                });
            }else
            {
                var _smtp = JSON.parse(registro.smtp);
                var _config = JSON.parse(registro.config);
                if(_smtp != null)
                {
                    record.smtpServer = _smtp.smtpServer,
                    record.smtpPuerto = _smtp.smtpPuerto,
                    record.smtpUsuario = _smtp.smtpUsuario,
                    record.smtpClave = _smtp.smtpClave
                }

                if(_config !=null)
                {
                    record.dirExtraccion = _config.dirExtraccion,
                    record.dirLeido = _config.dirLeido,
                    record.sepLinea = _config.sepLinea,
                    record.sepColumna = _config.sepColumna
                }
            }
            record.estado = registro.estado || 'ACT';
            return record;
        }
    }

}
</script>
