<template>
  <b-container>
    <b-row class="justify-content-center">
      <b-card>
        <b-card-body>
          <resetting-form></resetting-form>
        </b-card-body>
      </b-card>
    </b-row>
  </b-container>
</template>

<script>
import ResettingForm from "@/components/form/ResettingForm";

export default {
  name: "Resetting",
  components: { ResettingForm }
};
</script>

<style scoped>
</style>
