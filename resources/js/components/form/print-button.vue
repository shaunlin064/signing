<template>
    <button type="button" class="btn btn-outline-success waves-effect waves-light text-righ" @click='formPrint'>
        列印
    </button>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "print-button",
            props: {

            },
            data() {
                return {}
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {
                formPrint(){
                    bus.$emit('formPrint');
                }
            },
            updated() {
                // console.log('view updated')
            },
            watch: {

            }
        }
</script>

<style scoped>

</style>
