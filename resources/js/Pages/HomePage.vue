<script setup>
    import { Link } from "@inertiajs/vue3";
    import NavLayout from "../Layout/NavLayout.vue";
</script>

<template>
    <div>
       <NavLayout>
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <div class="card-body">
                        <h4>Sales Inventory </h4>
                        <Link href="/login" class="btn w-100 btn-success">Start </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
       </NavLayout>
    </div>
</template>

<style scoped>

</style>