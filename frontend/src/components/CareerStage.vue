<template>
  <b-row
    :class="parity"
    :startDate="startDate"
    :endDate="endDate"
    class="align-items-center"
  >
    <b-col cols="12" md="6">
      <b-card :title="title" :style="{ '--color': color }" class="border-0">
        <b-card-text>
          <h3 class="mt-4 font-weight-bold text-uppercase">{{ company }}</h3>
          <p class="mt-4 p-3 text-justify"><span v-html="description"></span></p>
        </b-card-text>
      </b-card>
    </b-col>
    <b-col cols="12" md="6">
      <h2 class="">
        <span>{{ formatDate(startDate) }}</span> - <span>{{ formatDate(endDate) }}</span>
      </h2>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: "CareerStage",
  props: {
    startDate: String,
    endDate: String,
    title: String,
    description: String,
    company: String,
    color: String,
    parity: String
  },
  methods: {
    // Format date to return the year of the date passed in paremeter
    formatDate(date) {
      const options = { year: "numeric" };
      let formatDate = new Date(date).toLocaleDateString(
        undefined,
        options
      );
      return formatDate.charAt(0).toUpperCase() + formatDate.slice(1);
    },
  }
};
</script>

<style lang="scss" scoped>
.row {
  width: 90%;
}
.col-12 {
  padding: 2rem;
}
h2 {
  font-family: "MontSerrat", sans-serif;
  font-weight: 600;
  font-size: 2.5rem;
  text-transform: uppercase;
  color: $white;
  transition: all 0.2s ease;
  animation: focus-in-contract 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) 1.5s
    both;
}
.card {
  font-family: "Oswald", sans-serif;
  background-color: transparent;
  &-body {
    padding: 0.75rem;
  }
  &-title {
    font-family: "MontSerrat", sans-serif;
    color: $white;
    font-weight: 600;
    text-transform: uppercase;
    border: 2px solid $white;
    padding: 1rem;
    @include box_shadow(0px, 0px, 5px, var(--color));
    z-index: 5;
  }
  &:before {
    content: "";
    position: absolute;
    background-color: $white;
    z-index: -1;
    width: 100%;
    height: 95%;
    @include box_shadow(0px, 0px, 10px, var(--color));
  }
  &:after {
    content: "";
    position: absolute;
    background-color: var(--color);
    width: 100%;
    height: 95%;
    z-index: -1;
    left: 2%;
    bottom: 5%;
    @include box-shadow(0px, 0px, 10px, var(--color));
  }
  &-text {
    h3 {
      color: $white;
    }
    p {
      color: $white;
    }
  }
  &:before,
  &:after {
    mix-blend-mode: multiply;
  }
}
.date {
  color: $white;
}
.odd {
  // margin: 4rem auto 6rem auto;
  transition: all 0.5s ease;
  .card {
    animation: slide-in-left 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) 1s both;
    &-text {
      h3 {
        text-align: right;
      }
    }
    &:after {
      transition: transform 0.4s ease;
      transform: rotateZ(4deg);
    }
    &:before {
      transition: transform 0.4s ease;
      transform: rotateZ(-5deg);
    }
    &-body {
      transition: transform 0.4s ease;
      transform: rotateZ(4deg);
    }
    &-title {
      color: $white;
      background-color: transparent;
    }
  }
  &:hover {
    cursor: default;
    .card {
      &:after {
        transition: all 0.4s ease;
        box-shadow: 5px 7px 2px $white;
        left: 0;
        bottom: 0;
        transform: rotateZ(0deg);
        height: 100%;
      }
      &:before {
        transition: all 0.4s ease;
        transform: rotateZ(0deg);
        height: 100%;
      }
      &-body {
        transition: all 0.4s ease;
        transform: rotateZ(0deg);
      }
      &-title {
        border: none;
        transition: all 0.4s ease;
        color: $white;
        background-color: var(--color);
        box-shadow: 5px 7px 2px $white, 0px 0px 15px var(--color);
      }
    }
    h2 {
      transition: all 0.2s ease;
      color: $light_blue;
    }
  }
}
.even {
  margin: 3rem auto 6rem auto;
  .card {
    animation: slide-in-right 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) 1s both;
    &:before {
      transition: transform 0.4s ease;
      transform: rotateZ(5deg);
    }
    &:after {
      transition: transform 0.4s ease;
      transform: rotateZ(-4deg);
    }
    &-body {
      transition: transform 0.4s ease;
      transform: rotateZ(-4deg);
      margin-left: .75rem;
    }
    &-text {
      h3 {
        text-align: left;
      }
    }
    &-title {
      transition: transform 0.4s ease;
      color: $white;
      border: 2px solid $white;
    }
  }
  &:hover {
    cursor: default;
    .card {
      &:after {
        transition: all 0.4s ease;
        box-shadow: -5px 7px 2px $white;
        left: 0;
        bottom: 0;
        transform: rotateZ(0deg);
        height: 100%;
      }
      &:before {
        transition: all 0.4s ease;
        transform: rotateZ(0deg);
        height: 100%;
      }
      &-title {
        border: none;
        transition: all 0.4s ease;
        color: $white;
        background-color: var(--color);
        box-shadow: -5px 7px 2px $white, 0px 0px 15px var(--color);
      }
      &-body {
        transition: all 0.4s ease;
        transform: rotateZ(0deg);
      }
    }
    h2 {
      transition: all 0.2s ease;
      color: $light_blue;
    }
  }
}
@keyframes focus-in-contract {
  0% {
    letter-spacing: 1em;
    filter: blur(12px);
    opacity: 0;
  }
  100% {
    filter: blur(0px);
    opacity: 1;
  }
}
@keyframes slide-in-left {
  0% {
    transform: translateX(-500px);
    opacity: 0;
  }
  100% {
    transform: translateX(0);
    opacity: 1;
  }
}
@keyframes slide-in-right {
  0% {
    transform: translateX(1000px);
    opacity: 0;
  }
  100% {
    transform: translateX(0);
    opacity: 1;
  }
}

@media (min-width: 320px) {
  .col-12 {
    padding: 1rem;
  }
  .even,
  .odd {
    flex-direction: column-reverse;
    width: 85%;
    margin: 1rem auto 0rem auto;
    h2 {
      font-size: 1.5rem;
      margin-bottom: 2rem;
    }
    .card {
      &-title {
        font-size: 1rem;
      }
      h3 {
        font-size: 0.9rem;
      }
      p {
        margin-top: 0!important;
        font-size: 0.7rem;
      }
    }
    &:hover {
      .card {
        &-title {
          border: 1px solid $white;
        }
      }
    }
  }
  .odd {
    h2 {
      text-align: right;
    }
  }
  .even {
    h2 {
      text-align: left;
    }
  }
}
@media (min-width: 576px) {
  .odd {
    .card {
      &-title {
        position: absolute;
        width: 65%;
        top: 0;
        left: 0;
        transform: translate(-2%, -50%);
      }
    }
    h2 {
      text-align: right;
    }
  }
  .even {
    .card {
      &-title {
        position: absolute;
        width: 65%;
        top: 0;
        right: 0;
        transform: translate(2%, -50%);
      }
    }
    h2 {
      text-align: left;
    }
  }
  h2 {
    font-size: 1.5rem;
  }
}
@media (min-width: 768px) {
  .col-12 {
    padding: 2rem;
  }
  .odd,
  .even {
    width: 90%;
    margin: 5rem auto 2rem auto;
    &:hover {
      h2 {
        font-size: 3rem;
        color: $light-blue;
      }
    }
    .card {
      &-title {
        width: 90%;
        margin: auto;
        font-size: 1rem;
      }
      h3 {
        font-size: 1.1rem;
      }
      p {
        margin-top: 1rem!important;
        font-size: 0.9rem;
      }
    }
  }
  .odd {
    flex-direction: row;
    h2 {
      text-align: left;
      font-size: 2rem;
    }
    .card {
      &-title {
        transform: translate(-10%, -70%);
      }
    }
    &:hover {
      .card {
        &-title {
          transform: translate(-8%, -70%) rotateZ(0deg);
        }
      }
    }
  }
  .even {
    flex-direction: row-reverse;
    .card {
      &-title {
        transform: translate(10%, -70%);
      }
    }
    h2 {
      text-align: right;
      font-size: 2.5rem;
    }
    &:hover {
      .card {
        &-title {
          transform: translate(8%, -70%) rotateZ(0deg);
        }
      }
    }
  }
}
@media (min-width: 992px) {
  .odd,
  .even {
    
    h2 {
      font-size: 3rem;
    }
    .card {
      &-body {
        font-size: 1.1rem;
      }
      &-title {
        width: 60%;
        font-size: 1.1rem;
      }
      h3 {
      font-size: 1.05rem;
      }
      p {
        margin-top: 1rem!important;
        font-size: 0.9rem;
      }
    }    
    &:hover {
      h2 {
        font-size: 3.25rem;
        color: $light-blue;
      }
    }
  }
}
@media (min-width: 1200px) {
  .odd,
  .even {
    .card {
      &-title {
        width: 60%;
        font-size: 1.4rem;
      }
      h3 {
      font-size: 1.5rem;
      }
      p {
        margin-top: 1rem!important;
        font-size: 1rem;
      }
    }    
  }
}
</style>
