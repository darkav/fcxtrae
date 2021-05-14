<template>
    <pantalla
        ref="pantalla"
        :menus="menus"
        :data="getExtraccion"
        :header="header"
        icono="<span class='mif-filter'></span>"
        linkStore="extraccion.store"
        linkUpdate="extraccion.update"
        linkDelete="extraccion.destroy"
        linkBack="extraccion.index"
        :convertRecord="transformar"
        titulo="Extracciones"
    >
        <template v-slot:default="parent">
            <div class="row mb-2 d-flex flex-align-center">
                <label class="cell-3">Compañia</label>
                <div class="cell-9">
                    <select data-role="select" v-model="parent.form.compania_id">
                        <option
                            v-for="(cia,cix) in getCias" :key="cix"
                            :value="cia.id"
                        >
                            {{cia.razon_social}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mb-2 d-flex flex-align-center">
                <label class="cell-3">Tipo de Documento</label>
                <div class="cell-9">
                    <select data-role="select" v-model="parent.form.tipodoc_id">
                        <option
                            v-for="(tpd,tix) in getTipoDocs" :key="tix"
                            :value="tpd.id"
                        >
                            {{tpd.nombre}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row mb-2 d-flex flex-align-center">
                <label class="cell-3">Nombre</label>
                <div class="cell-9">
                    <input type="text" v-model="parent.form.nombre" class="metro-input" >
                </div>
            </div>
            <div data-role="panel" data-title-caption="Selección de campos DOCS. SRI" data-collapsible="true" class="mb-4">
                <div class="row w-100 flex-justify-center">
                    <div class="cell-6 my-4">
                        <div class="button outline primary w-100" @click="showCharm(true)">Ver Esquema</div>
                    </div>
                </div>

                <div class="row">
                    <label class="cell-12">Cabecera</label>
                    <div class="cell-12">
                        <input type="text" data-role="tag-input" v-model="parent.form.cabecera" class="metro-input" >
                    </div>
                </div>

                <div class="row">
                    <label class="cell-12">Detalle</label>
                    <div class="cell-12">
                        <input type="text" data-role="tag-input" v-model="parent.form.detalle" class="metro-input" >
                    </div>
                </div>

                <div class="row">
                    <label class="cell-12">Impuestos</label>
                    <div class="cell-12">
                        <input type="text" data-role="tag-input" v-model="parent.form.impuesto" class="metro-input" >
                    </div>
                </div>

                <div class="row">
                    <label class="cell-12">Adicionales</label>
                    <div class="cell-12">
                        <input type="text" data-role="tag-input" v-model="parent.form.adicional" class="metro-input" >
                    </div>
                </div>

            </div>
            <div class="w-25" id="charme" data-role="charms" data-position="right">
                <div class="card w-100">
                    <div class="card-header">
                        <row class="row w-100 flex-justify-center">
                            <div class="cell-8">
                                <div class="button outline primary w-100" @click="showCharm(false)">Cerrar</div>
                            </div>
                        </row>
                    </div>
                    <div class="card-content p-2">
                        <tree ref="tree" :data="getEsquema"></tree>
                    </div>
                </div>
            </div>


        </template>
    </pantalla>

</template>
<script>
import Pantalla from '../../controles/pantalla';
import Tree from '../../controles/treeview';
export default {
    props:["companias","tipodocs","extracciones","docsxml","menus"],
    components:{
        'pantalla': Pantalla,
        'tree' : Tree
    },
    mounted()
    {
        console.log("pantallas", this);
        this.$refs.pantalla.showForm('B');        
    },
    data(){
        return{
            accion:"B",
            header:[
                {label: "Id", campo: "id"},
                {label: "Compania Id", campo: "compania_id"},
                {label: "Compañía", campo: "compania"},                
                {label: "Tipo Docs Id", campo: "tipodoc_id"},
                {label: "Tipo Documento", campo: "tipodoc"},
                {label: "Nombre", campo: "nombre"},
                {label: "Estado", campo: "estado"}
            ],
            esquema:[]
        }
    },
    computed:
    {
        getExtraccion()
        {
            this.extracciones.map((x) => {
                x.compania = this.companias.find(c => c.id == x.compania_id).razon_social;
                x.tipodoc = this.tipodocs.find( t => t.id == x.tipodoc_id).nombre;
            });
            return this.extracciones;
        },
        getCias()
        {
            return this.companias;
        },
        getTipoDocs()
        {
            return this.tipodocs;
        },
        getEsquema()
        {
            let myfrm = this.$refs.pantalla.getForm();
            if(myfrm.tipodoc_id == null) return [];
            let xmldoc = this.docsxml.find(x => x.tipodoc.id == myfrm.tipodoc_id);
            this.esquema = JSON.parse(xmldoc.xml);
            return this.esquema || [];
        },

    },methods: {
        transformar(registro,modo)
        {
            var record = {};

            record.id = registro.id;
            record.compania_id = registro.compania_id;
            record.tipodoc_id = registro.tipodoc_id;
            record.nombre = registro.nombre
            if(modo == "STORE")
            {
                record.documento = JSON.stringify( {
                    cabecera : registro.cabecera,
                    detalle : registro.detalle,
                    impuesto : registro.impuesto,
                    adicional : registro.adicional
                });
            }else
            {
                var _doc = JSON.parse(registro.documento);
                if(_doc != null)
                {
                    record.cabecera = _doc.cabecera,
                    record.detalle = _doc.detalle,
                    record.impuesto = _doc.impuesto,
                    record.adicional = _doc.adicional
                }
            }
            record.estado = registro.estado || 'ACT';
            return record;
        },

        showCharm(flag)
        {

            console.log("ejecutando el tree",this.getEsquema,this.$refs.pantalla.getForm(),this.docsxml);
            this.$refs.tree.exec();

            if(flag)
                Metro.charms.open("#charme");
            else
                Metro.charms.close("#charme");
        }
        
    },
}
</script>