<template>
    <template v-for="quotation in quotations">
        <quotation :quotation="quotation"></quotation>
    </template>
</template>

<script>
    export default {
        ready() {
            console.log('QuotationList ready.');
            this.$nextTick(function () {
                this.fetch();
            });
        },
        props: ['quotations', 'api'],
        methods: {
            fetch: function () {
                this.$http.get(this.api).then(function (response) {
                    var json = response.json();
                    var quotations = [];
                    $.each(json, function (key, value) {
                        console.log(value);
                        quotations.push(value);
                    });
                    this.quotations = quotations;
                });
            }
        }
    }
</script>
