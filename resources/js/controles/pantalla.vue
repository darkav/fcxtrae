<template>
    <div class="w-100 h-100" :key="rfsform">
        <div v-if="accion == 'B'" data-role="panel"
            :data-title-caption="titulo"
            :data-title-icon="icono"
            class="w-100 h-100"
            
        >
            <div class="scrollbox">
                <div class="grid">
                    <div class="row w-100">
                        <div class="cell-6">
                            <input type="text" class="metro-input"
                                data-role="input"
                                data-search-button="true"
                                data-on-search-button-click="searchData"
                                v-model="searched"
                            >
                        </div>

                        <div class="cell-6 d-flex flex-row-r">
                            <div class="toolbar">
                                <button class="tool-button primary outline" @click="$inertia.reload({only: ['data']})"><span class="mif-refresh icon"></span></button>
                                <button class="tool-button primary outline" @click="showForm('N')"><span class="mif-file-empty icon"></span></button>
                                <button class="tool-button primary outline"><span class="mif-exit icon"></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="cell-12">
                            <table class="mitabla table subcompact row-hover striped table-border  mt-4"
                            >
                                <thead>
                                    <tr>
                                        <!-- "sortable-column sort-asc" -->
                                        <th :class="head.clase"
                                            v-for="(head,hix) in header"
                                            :key="hix"
                                        >{{head.label}}</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <!-- style="height: 150px !important;" -->
                                <tbody>
                                    <tr 
                                        v-for="(fila,fix) in getFiltro || []"
                                        :key="fix"
                                    >
                                        <td v-for="(col,cix) in header"
                                        :key="cix"
                                        >
                                            {{ fila[col.campo] }}
                                        </td>
                                        <td>
                                            <div class="toolbar" style="height: 36px;">
                                                <slot name="extra-comando" v-bind:fila="fila"></slot>
                                                <div class="tool-button secondary outline" @click="editForm(fila)"><span class="mif-pencil "></span></div>
                                                <div class="tool-button alert outline" @click="deleteForm(fila)"><span class="mif-cross"></span></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if= " 'N|E'.includes(this.accion) " data-role="panel"
            :data-title-caption="'Mantenimiento de ' + titulo"
            :data-title-icon="icono"
            data-main-panel="true"
            class="w-100 h-100">

            <div :class="sizeclase">
                <div class="card-content p-2">
                    <form ref="frmMantenimiento">
                        <slot v-bind:form="form"/>
                    </form>
                </div>
                <div v-if="showBotones" class="card-footer d-flex flex-row flex-justify-center">
                    <button v-show="linkStoreShow" class="button primary outline m-2" @click="submit"><span class="mif-floppy-disk"></span></button>
                    <button class="button alert outline" @click="close"><span class="mif-exit"></span></button>
                </div>
            </div>
            
        </div>
        <div v-if="accion == 'R'" data-role="panel"
            :data-title-caption="titulo"
            :data-title-icon="icono"
            data-main-panel="true"
            class="w-100 h-100"     
            data-cls-content="h-100 w-100"   
        >
            <slot name="reporte"/>
        </div>
        
    </div>
</template>
<script>
    import AvsisLayout from '../Layouts/AvsisLayout';
    import busqueda from '../Mixes/busqueda';

    export default{
        components:{
            //AvsisLayout
        },
        mixins: [busqueda],
        props:{
            data: {
                type: Array
            },
            menus: {
                type: Array
            },
            header: {
                type: Array
            },
            linkCreate:{
                type: String
            },
            linkEdit:{
                type: String
            },
            linkDelete:{
                type: String
            },
            linkStore:{
                type: String
            },
            linkUpdate:{
                type: String
            },
            linkBack:{
                type: String
            },
            titulo:{
                type: String
            },
            icono:{
                type: String
            },
            registro:{
                type: Object
            },
            linkStoreShow:{
                type: Boolean,
                default: true
            },
            showBotones:{
                type: Boolean,
                default: true
            },
            sizeclase:{
                type: String,
                default: "card w-50"
            },
            convertRecord:{
                type: Function,
                default: (valor,modo) => valor
            }
        },
        mounted(){
            console.log("montado otra vez",this.accion);
            if("N|E".includes(this.accion))
            {
                this.form = this.registro ;
                console.log("accion pantalla",this.form,this.accion);

            }
                
        },
        data(){
            return{
                form: {},
                accion:"X",
                rfsform:0
            }
        },
        computed:{
            getData()
            {
                console.log("data refrescando", this.data);
                return this.data;
            }

        },
        methods:{
            showForm(_accion){
                //this.$inertia.get(route(this.linkCreate));
                this.accion=_accion;
                this.rfsform++;
            },
            editForm(fila){
                //console.log("Edit Form", fila,this.linkEdit);
                //this.$inertia.get(route(this.linkEdit,fila.id));
                this.form =  this.convertRecord(fila,"UPDATE")
                console.log("mi formulario form",this.form);
                this.showForm("E");

            },
            deleteForm(fila)
            {
                if(!confirm("Estas seguro que desea eliminar este registro")) return;
                this.$inertia.delete(route(this.linkDelete,fila.id));
            },
            submit()
            {
                console.log("entrando al submit",this.accion);
                var formTransform = this.convertRecord(this.form,"STORE");
                switch(this.accion)
                 {
                        case 'N':
                            var vform = Object.assign({},formTransform);
                            this.$inertia.post(route(this.linkStore),vform, {
                                onSuccess: () => {
                                    this.$refs.frmMantenimiento.reset();
                                }
                            });
                            break;
                        case 'E':
                            var vform = Object.assign({},formTransform);
                            console.log("Grabando la informacion de edicion", vform);
                            this.$inertia.put(route(this.linkUpdate,vform.id),vform);
                            break;
                 }

                
                },
                close()
                {
                    console.log("back of the future",this.linkBack);
                    this.$inertia.get(route(this.linkBack));
                },

                setForm(objeto)
                {
                    this.form = objeto;
                },

                getForm(objeto)
                {
                    return this.form;
                }




        }
    }

</script>