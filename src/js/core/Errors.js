class Errors {

    constructor(){

        this.errors = {};

    }

    /**
     * Specific field error text
     * @param  {string}     field name
     * @return {string}     error text
     */
    get(field){

        if(this.errors[field]){
            return this.errors[field][0];
        }

    }

    /**
     * Records new errors
     * @param  {[type]}
     * @return {[type]}
     */
    record(errors){

        this.errors = errors;

    }

    /**
     * Crears all errors or specific error of field
     * @param  {[type]}
     * @return {[type]}
     */
    clear(field){

        if(field){
            delete this.errors[field];
            return;
        }

        this.errors;
    }

    /**
     * Checks if field has an error
     * @param  {[type]}
     * @return {Boolean}
     */
    has(field){

        return this.errors.hasOwnProperty(field);

    }

    /**
     * Checks if there is any errors
     * @return {[type]}
     */
    any() {

        return Object.keys(this.errors).length > 0;

    }

}

export default Errors;