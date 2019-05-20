import Errors from './Errors';

class Form {

    constructor(data) {

        this.originalData = data;

        for (let field in data){
            this[field] = data[field];
        }

        this.errors = new Errors();

    }

    /**
     * Resets the form
     * @return {[type]}
     */
    reset() {

        for (let field in this.originalData){
            this[field] = '';
        } 

        this.errors.clear();

    }

    /**
     * Gets only needed data for sending
     * @return {[type]}
     */
    data() {

        let data = {};

        for(let property in this.originalData){
            data[property] = this[property];
        }

        return data;

    }

    /**
     * Helper for post request
     * @param  {[type]}
     * @return {[type]}
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * Helper for get request
     * @param  {[type]}
     * @return {[type]}
     */
    get(url) {
        return this.submit('get', url);
    }

    /**
     * Helper for delete request
     * @param  {[type]}
     * @return {[type]}
     */
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * Submits the request of form
     * @requestType {string}
     * @url         {string}
     * @return      {[type]}
     */
    submit(requestType, url) {

        return new Promise((resolve, reject) => {
            
            axios
                [requestType](
                    url,
                    (requestType=='get') ? { params: this.data() }: this.data
                )
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response);
                })
                .catch(error => {
                    this.onFail(error.response);

                    reject(error.response);
                });

        });

    }

    /**
     * Action on success
     * @param  {[type]}
     * @return {[type]}
     */
    onSuccess(data) {

        this.errors.clear();
        // this.reset();

    }

    /**
     * Action on fail
     * @param  {[type]}
     * @return {[type]}
     */
    onFail(errorResponse) {

         this.errors.record(errorResponse.data.errors)

    }

}

export default Form;