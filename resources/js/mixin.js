import moment from 'moment';
export default {
    data: function () {
        return {
            dateFormat: 'yyyy-MM-dd',
        }
    },
    methods: {
        moment: function (date) {
            return moment(date).format('Do MMMM YYYY');
        },
        showMassage(data){
            if(data.status === 'success'){
                toastr.success(data.message, 'Success Alert');
            }else if(data.status === 'error'){
                toastr.error(data.message, 'Error Alert');
            }else{
                toastr.error(data.message, 'Error Alert');
            }
        },

        incrementItem(number) {
            number +=1;
            return number
        },

        changePerPage(){
            var _this = this;
            _this.index(1,_this.perPage);
        },
    },
}
