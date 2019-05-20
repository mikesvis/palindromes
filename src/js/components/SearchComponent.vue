<template>
    <div class="searcher">    

        <search-form></search-form>        

        <search-results></search-results>

    </div>
</template>

<script>

    Vue.component('search-form', require('./SearchFormComponent.vue').default);
    
    Vue.component('search-results', require('./SearchResultsComponent.vue').default);

    export default {
        
    }

</script>