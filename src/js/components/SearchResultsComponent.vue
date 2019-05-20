<template>

    <div class="columns">
        
        <div class="column is-full">
            <ul>
            	<li v-for="result in resultsList" v-text="result"></li>
            </ul>
        </div>

    </div>      

</template>

<script>
    export default {
    	created () {
            // seting up event listeners for events
  			eventHub.$on('resultsRecieved', this.renderResults);
  			eventHub.$on('resultsClear', this.clearResults);
		},
    	data(){
            return {
                resultsList: []
            }
        },
        methods: {
        	renderResults(data){
        		this.resultsList = data;
        	},
        	clearResults(){
        		this.resultsList = [];
        	}
        }
    }
</script>