<template>
  <div :class="{ active: isActive }">
    <button type="button" class="menu-icon m-4" :style="{ '--color': color }" @click="toggle"> 
      <span class=" menu-line-top"></span>
      <span class=" menu-line-bottom"></span>
    </button>
  </div>
</template>

<script>
import { menuStore, mutations } from "@/store/menuStore.js"

export default {
  name: "MenuIcon",
  props: {
    color: String
  },
  computed: {
    isActive() {
      return menuStore.isNavOpen
    }
  },
  methods: {
    toggle() {
      mutations.toggleNav()
    }
  },
}
</script>

<style lang="scss">
.menu {
  &-icon {
    width: 2rem;
    height: 2rem;
    background-color: transparent;
    border: 1px solid var(--color);
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease-in-out;
    @include box_shadow(0, 0, 20px, var(--color));
    border-radius: 10%;
    z-index: 11;
    &:hover {
      background-color: var(--color);
      @include box_shadow(0, 0, 20px, var(--color));
    }
  }
  &-line {
    &-top {
      transition: all 0.3s ease-in-out;
      position: absolute;
      top: 0;
      transform: translate(-50%, -50%);
      border: 1px solid transparent;
      width: 100%;
    }
    &-bottom {
      transition: all 0.3s ease-in-out;
      position: absolute;
      bottom: 0;
      transform: translate(-50%, 50%);
      border: 1px solid transparent;
      width: 100%;
    }
  }
}
.active {
  .menu {
    &-icon {
      border-radius: 50%;
      background-color: var(--color);
      @include box_shadow(0, 0, 20px, var(--color));
    }
    &-line {
      &-top {
        @include box_shadow(0, 0, 20px, var(--color));
        border: 1px solid var(--color);
        transform: translate(-100%, -50%);
      }
      &-bottom {
        @include box_shadow(0, 0, 20px, var(--color));
        border: 1px solid var(--color);
        transform: translate(0%, 50%);
      }
    }
  }
}
</style>