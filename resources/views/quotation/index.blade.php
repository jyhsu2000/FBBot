@extends('layouts.app')

@section('title', '資安語錄')

@section('content')
    <h1>資安語錄</h1>
    {{-- FIXME --}}
    @{{ data }}
    <div>
        <ul class="list-group">
            <quotation>test</quotation>
            <template v-for="quotation in quotations">
                <quotation>@{{ quotation.content }}</quotation>
            </template>
        </ul>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el: 'body',
            data: {
                quotations: [1, 2, 3]
            },
            created: function () {
                console.log('mounted');
                this.$nextTick(function () {
                    this.fetch();
                });
            },
            methods: {
                fetch: function () {
                    console.log('fetch');
                    this.$http.get('{{ route('quotation.data') }}').then(function (response) {
                        var json = response.data;
                        console.log(json);
                        var quotations = {};
                        $.each(json, function (key, value) {
                            quotations.push(value);
                        });
                        this.quotations = quotations;
                    });
                }
            }
        });
    </script>
@endsection
