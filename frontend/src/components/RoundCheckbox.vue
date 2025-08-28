<template>
  <div class="checkbox-wrapper">
    <label class="checkbox-gradient">
      <input
        type="radio"
        class="checkbox-input peer"
        :name="name"              
        :value="value"            
        :checked="String(modelValue) === String(value)"
        @change="$emit('update:modelValue', $event.target.value);"
      />

      <!-- círculo negro interior -->
      <span class="checkbox-circle peer-checked:size-0"></span>

      <!-- palitos del check -->
      <span class="checkbox-line-long"></span>
      <span class="checkbox-line-short"></span>
    </label>

    <span v-if="label" class="checkbox-text">{{ label }}</span>
    <slot v-else></slot>
  </div>
</template>

<script>
export default {
  name: "RoundCheckbox",
  props: {
    name: { type: String, required: true },
    modelValue: { type: [String, Boolean], default: null },
    value: { type: [String, Boolean], required: true },
    label: { type: String, default: "" }
  },
  emits: ["update:modelValue"]
};
</script>
