<script setup>
defineProps({
  name: String,
});
</script>

<template>
  <div class="form-group ">
    <label :for="name">
      <slot name="label"></slot>
    </label>
    <slot></slot>
  </div>
</template>
