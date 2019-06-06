<template>
    <b-container>
        <b-row class="justify-content-center">
            <b-card>
                <b-card-body>
                    <register-form></register-form>
                </b-card-body>
            </b-card>
        </b-row>
    </b-container>
</template>

<script>
import RegisterForm from "@/components/form/RegisterForm";

export default {
  name: "SignUp",
  components: { RegisterForm }
};
</script>

<style scoped>
</style>
