<template>
    <div id="treecont" style="overflow-y: scroll; height: 89vh;" key='rfstree'>
    </div>
</template>
<script>
export default {
    props:["data"],
    created(){

    },
    data(){
        return{
            body:[],
            rfstree:0
        }
    },
    methods:{
        createControl(listado,contenido,level)
        {
            let nodoDom = '';
            // data-icon="<span class='mif-home'></span>" data-caption="${x}"></li>
            // necesito poner objeto como referencia para los niveles
            Object.keys(listado).map((x) => {
                if(!isNaN(x) && !isNaN(Object.keys(listado[x])[0])){ 
                    return ;
                };
                if(Object.keys(listado[x]).length > 0)
                {
                    nodoDom = ` <div class="row fg-blue ml-${level.nivel - 1}">
                                    <div class="cell-3 fg-orange"><span class="${level.nivel == 1 ?  'mif-books' : 'mif-book-reference'}"></span></div>
                                    <div class="cell-5 ml-${level.nivel - 1}"><span>${x}</span></div>
                                </div>`;
                    contenido.push(nodoDom);
                }
                ++level.nivel;
                this.createControl(listado[x],contenido,level);
                level.nivel--;
            });
        },
        isNodoTree(nodo)
        {
            return true;
        },
        exec()
        {
            var level = {};
            level.nivel = 1;
            this.body=[];
            this.createControl(this.data,this.body,level);
            let html = this.body.toString().replace(/,/g,"");
            var result = Metro.template(html,{});
            $("#treecont").html(result);
            this.rfstree++;
        }
    

    }
}
</script>