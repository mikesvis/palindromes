<template>
	
	<form class="input-transparent" method="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

		<div class="columns">

			<div class="column is-three-quarters">
			    <div class="field">
					<input 
						type="text"
						name="searchString" 
						placeholder="Введите строку в которой стоит искать палиндромы" 
						v-model="form.searchString" 
						class="input"
						:class="{ 'is-danger' : form.errors.has('searchString') }" 
					/>
					<small class="help is-danger" v-if="form.errors.has('searchString')" v-text="form.errors.get('searchString')"></small>
			    </div>
			</div>

			<div class="column is-one-quarter">
		    	<div class="control">
		    		<button class="button is-link" type="submit">Найти</button>
				</div>
			</div>

		</div>

	</form>

</template>

<script>
    export default {
        data(){
            return {
            	// initializing form from From class
                form: new Form({
                    searchString: "",
                }),
            }
        },
        methods: {
            onSubmit(){

            	// sending request
                this.form.get('/request.php')
                    .then(function(response){
                       	eventHub.$emit('resultsRecieved', response.data);
                    }).catch(function(error){
                    	eventHub.$emit('resultsClear');
                    });
                        
            },
        }
    }
</script>