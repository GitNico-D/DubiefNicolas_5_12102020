<template>
  <router-link
    :to="url"
    :class="direction"
    :style="{ '--text-color': textColor, '--hover-color': hoverColor }"
  >
    <span class="the-arrow">
      <span class="shaft"></span>
    </span>
    <span class="main">
      <span class="text">{{ action }}</span>
      <span class="the-arrow -right">
        <span class="shaft"></span>
      </span>
    </span>
  </router-link>
</template>

<script>
export default {
  name: "HomePageLink",
  props: {
    action: String,
    url: String,
    direction: String,
    textColor: String,
    hoverColor: String
  }
}
</script>

<style lang="scss">
.animated-arrowRtl {
  display: inline-block;
  color: var(--text-color);
  font-size: 1.75em;
  position: relative;
  transition: all 0.2s;
  .main {
    display: flex;
    align-items: center;
    transition: all 0.2s;
    .text {
      font-family: "Oswald", sans-serif;
      margin: 0 $text-arrow-space 0 0;
      line-height: 1;
      letter-spacing: 3px;
    }
    .the-arrow {
      position: relative;
    }
  }
  &:hover {
    color: var(--hover-color);
    .main {
      transform: translateX($shaft-width + $text-arrow-space);
      .the-arrow.-right {
        .shaft {
          width: 0;
          transform: translateX(200%);
          background-color: var(--hover-color);
          @include box_shadow;
          &:before,
          &:after {
            width: 0;
            transition: all 0.1s;
          }
          &:before {
            transform: rotate(0);
          }
          &:after {
            transform: rotate(0);
          }
        }
      }
      .text {
        @include text_shadow_hover(0px, 0px, 5px, var(--hover-color));
      }
    }
    .the-arrow {
      .shaft {
        @include box_shadow(0px, 0px, 10px, var(--hover-color));
        background-color: var(--hover-color);
      }
    }
  }
  .the-arrow {
    width: $shaft-width;
    transition: all 0.2s;
    &.-right {
      top: 2px;
      .shaft {
        width: $shaft-width;
        &:before,
        &:after {
          width: $arrow-head-width;
          transition: all 0.5s;
        }
        &:before {
          transform: rotate(40deg);
        }
        &:after {
          transform: rotate(-40deg);
        }
      }
    }
    .shaft {
      background-color: var(--text-color);
      display: block;
      height: $shaft-thickness;
      position: relative;
      transition: all 0.2s;
      will-change: transform;
      &:before,
      &:after {
        background-color: var(--text-color);
        content: "";
        display: block;
        height: $arrow-head-thickness;
        position: absolute;
        top: 0;
        right: 0;
        transition: all 0.2s;
      }
      &:before {
        transform-origin: top right;
      }
      &:after {
        transform-origin: bottom right;
      }
    }
  }
}

.animated-arrowLtr {
  display: inline-block;
  color: var(--text-color);
  font-size: 1.75em;
  position: relative;
  transition: all 0.2s;
  .main {
    display: flex;
    align-items: center;
    transition: all 0.2s;
    .text {
      font-family: "Oswald", sans-serif;
      margin: 0 0 0 ($shaft-width + $text-arrow-space);
      line-height: 1;
      letter-spacing: 3px;
    }
    .the-arrow {
      position: absolute;
      top: 50%;
    }
  }
  &:hover {
    color: var(--hover-color);
    .main {
      transform: translateX(-($shaft-width + $text-arrow-space));
      .the-arrow.-right {
        width: $shaft-width;
        transition: all 0.2s;
        .shaft {
          width: 0;
          transform: translateX(200%);
          &:before,
          &:after {
            width: 0;
            transition: all 0.1s;
          }
          &:before {
            transform: rotate(0);
          }
          &:after {
            transform: rotate(0);
          }
        }
      }
      .text {
        @include text_shadow_hover(0px, 0px, 5px, var(--hover-color));
      }
    }
    .the-arrow {
      .shaft {
        @include box_shadow(0px, 0px, 10px, var(--hover-color));
        background-color: var(--hover-color);
      }
    }
  }
  .the-arrow {
    &.-right {
      top: 18px;
      .shaft {
        width: $shaft-width;
        &:before,
        &:after {
          width: $arrow-head-width;
          transition: all 0.5s;
        }
        &:before {
          transform: rotate(40deg);
        }

        &:after {
          transform: rotate(-40deg);
        }
      }
    }
    .shaft {
      background-color: var(--text-color);
      display: block;
      height: $shaft-thickness;
      position: relative;
      transition: all 0.2s;
      will-change: transform;
      &:hover {
        @include box_shadow;
      }
      &:before,
      &:after {
        background-color: var(--text-color);
        content: "";
        display: block;
        height: $arrow-head-thickness;
        position: absolute;
        top: 0;
        left: 0;
        transition: all 0.2s;
      }
      &:before {
        transform-origin: bottom left;
      }
      &:after {
        transform-origin: top left;
      }
    }
  }
}
</style>
