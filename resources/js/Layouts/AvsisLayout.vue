<template>
    <main >
        <header>
            <div v-if="$page.props.flash.message" class="bg-blue fg-white w-100">
                <div class="d-flex flex-row flex-justify-end">
                    <div class="mr-auto ml-2">
                        <span>{{ $page.props.flash.message }}</span>
                    </div>
                    <div class="mr-2">
                        <span class="mif-cross icon fg-red"
                            @click="$page.props.flash.message = undefined"
                        ></span>
                    </div>
                </div>
            </div>
        </header>
        <content>
            <div data-role="navview" class="pagina">
                <div class="navview-pane">
                    <button class="pull-button">
                        <span class="default-icon-menu"></span>
                    </button>
                    <div class="suggest-box">
                        <input type="text" data-role="input" data-clear-button="false" data-search-button="true">
                        <button class="holder">
                            <span class="mif-search"></span>
                        </button>
                    </div>
                    <ul class="navview-menu">
                        <li class="item-header">Facelec<b>X</b>Trae</li>
                        <li class="item-separator"></li>
                        <template v-for="(menu,mix) in getMenus" :key="mix">
                            <li class="item-header" >{{menu.modulo}}</li>
                            <template v-for="(programa,pix) in menu.programas" :key="pix">
                                <li>
                                    <a :href="programa.link">
                                        <span class="icon"><span :class="programa.icono"></span></span>
                                        <span class="caption">{{programa.programa}}</span>
                                    </a>
                                </li>
                            </template>
                            <li class="item-separator"></li>
                        </template>
                    </ul>
                </div>
                <div class="navview-content d-flex flex-align-center flex-justify-center h-100">
                    <slot/>
                </div>
            </div>

        </content>
        
    </main>
</template>
<script>
export default {
    mounted(){
    const el = document.getElementById('app');
    let dataset = JSON.parse(el.dataset.page);
    this.menus = dataset.props.menus;
    console.log("el datapage en layout", dataset.props.menus );

        //Metro.init();
    },
    data(){
        return{
            menus: []
        }
    },
    computed:{
        getMenus()
        {
            return this.menus || [];
        }
    }
}
</script>
