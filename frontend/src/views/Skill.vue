<template>
  <b-container fluid>
    <Header title="Compétences" color="#36C486" />
    <CircleBackground circleColor="#36C486"/>
    <Transition v-show="showTransition" directionAnimation="up" colorSlideOne="#36C486"/>
    <b-row class="skill-title justify-content-around">
      <b-button
        v-for="categories in allCategories"
        :key="categories.id"
        @click="current = categories.id"
        :class="[{ current: categories.id == current}, 'from-center'] "        
      >
        {{ categories.name }}
      </b-button>
    </b-row>
    <b-row
      v-for="categories in allCategories"
      :key="categories.allCategories"
      class="skill-description"
      :style="categories.id != current ? {'display': 'none'} : ''"
    >
      <b-col cols="8" class="m-auto" v-show="current == categories.id">
        <div class="d-flex justify-content-around align-items-center flex-wrap">
          <figure class="figure" 
            v-for="skill in categories.skills" 
            :key="skill.id">
            <img :src="skill.icon" class="figure-img img-fluid rounded">
            <figcaption class="figure-caption text-center">{{ skill.name }}</figcaption>
          </figure>
        </div>
      </b-col>
      <b-col cols="8" class="m-auto">
        <div
          v-show="current == categories.id"
          class="software-block justify-content-around align-items-center flex-wrap">
          <h4 class="software-title text-center mb-5">Logiciel associées</h4>
          <figure class="figure" 
            v-for="software in categories.softwares"
            :key="software.id">
            <img :src="software.icon" class="figure-img img-fluid rounded">
            <figcaption class="figure-caption text-center">{{ software.name }}</figcaption>
          </figure>
        </div>
      </b-col>
    </b-row>
    <b-row class="back justify-content-center align-items-center mt-5 mb-2">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowRtl"
        class="link-bottom"
        textColor="#36C486"
        hoverColor="#36C486"
      />
    </b-row>
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import Header from "@/components/Header.vue";
import Transition from "@/components/Transition.vue";
import CircleBackground from '@/components/CircleBackground.vue'
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    HomePageLink,
    Header,
    Transition,
    CircleBackground,
  },
  data() {
    return {
      current: 1,
      showTransition: true
    };
  },
  methods: {
    // Hide or show slider transition
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    ...mapActions(["getAllCategories"])
  },
  computed: {
    ...mapGetters(["allCategories"]),
    
  },
  created() {
    // Hide slider transition after created
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  mounted() {
    // Dispatch all categories contains in the vuex state.projects
    this.$store.dispatch("getAllCategories");
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  perspective: 1000px;
  position: relative;
  min-height: 100vh;
  overflow: hidden;
  .back {
    height: 15vh;
  }
  .btn {
    font-family: "Montserrat", sans-serif;
    color: $white;
    border: none;
    transition: all 500ms cubic-bezier(0.77, 0, 0.175, 1);
    position: relative;
    margin: 0.5rem;
    letter-spacing: 0.5rem;
    text-transform: uppercase;
    &:before, &:after {
      content: '';
      position: absolute;
      transition: inherit;
      z-index: -1;
    }
    &:hover {
      cursor: pointer;
      color: $green;
      transition-delay: .5s;  
      &:before {
        transition-delay: 0s;
      }   
      &:after {
        background: $white;
        transition-delay: .35s;
      }
    }
    &:active {
      background-color: $green !important;
    }
    &:focus {
      box-shadow: none;
    }
    &-secondary {
      background-color: inherit;
      &:hover {
        background-color: inherit;
      }
    }
  }
  col {
    margin: 0;
    padding: 0;
  }
  .current {
    color: $green;
    background-color: $white;
  }
  .figure {
    width: 12vw;
    margin: 1rem;
    border: 1px solid transparent;
    &-caption {
      font-family: 'Oswald', sans-serif;
      letter-spacing: 0.1rem;
      &:hover {
        @include text_shadow;
      }
    }
    animation: bounce-in-fwd 1.1s both;
    @for $i from 1 through 20 {
      &:nth-child(#{$i}) {
        animation-delay: $i * 0.2s;
      }
    }
    &:hover {
      .figure { 
        &-img, &-caption {
          transform: scale(1.1);
        }
      }
    }
  }
  .from-center{
    &:before {
      top: 0;
      left: 50%;
      height: 100%;
      width: 0;
      border: 1px solid $green;
      border-left: 0;
      border-right: 0;
    }
  }
  .from-center {
    &:after {
      bottom: 0;
      left: 0;
      height: 0;
      width: 100%;
      background: $green;
    }
  }
  .from-center:hover:before {
    left: 0;
    width: 100%;
  }
  .from-center:hover:after {
    top: 0;
    height: 100%;
  }
  .skill {
    &-title {
      width: 80%;
      margin: auto;
      height: unset;
      animation: scale-up-center 0.4s cubic-bezier(0.39, 0.575, 0.565, 1) 0.8s
        both;
    }
    &-description {
      height: unset;      
      animation: scale-up-hor-right 0.5s cubic-bezier(0.39, 0.575, 0.565, 1)
        both;
    }
  }
  .software {
    &-title {
      font-family: "Montserrat", sans-serif;
      color: $white;
    }
  }
  .icon-circle {
    border: 2px solid black;
    list-style: none;
    border-radius: 50%;
  }
}
@keyframes scale-up-center {
  0% {
    transform: scale(0.1);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes bounce-in-fwd {
  0% {
    -webkit-transform: scale(0);
            transform: scale(0);
    -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in;
    opacity: 0;
  }
  20% {
    -webkit-transform: scale(1);
            transform: scale(1);
    -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out;
    opacity: 1;
  }
  40% {
    -webkit-transform: scale(0.8);
            transform: scale(0.8);
    -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in;
  }
  60% {
    -webkit-transform: scale(1);
            transform: scale(1);
    -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out;
  }
  80% {
    -webkit-transform: scale(0.95);
            transform: scale(0.95);
    -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in;
  }
  100% {
    -webkit-transform: scale(1);
            transform: scale(1);
    -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out;
  }
}
@media (min-width: 320px) {
  .container-fluid {
    .back {
      .link {
        &-bottom {
          transform: rotateZ(-90deg) scale(0.5);
        }
      }
    }
    .skill {
      &-title {
        flex-direction: column;
        padding-top: 3rem;
      }
    }
    .software {
      &-title {
        text-align: left;
        font-size: 0.9rem;
        margin-top: 2rem;
      }
    }
  }
}
@media (min-width: 768px) {
  .container-fluid {
    .skill {
      &-title {
        flex-direction: row;
      }
    }
    .btn {
      font-size: 0.9rem;
      padding: 0.75rem 1.1rem 0.75rem 1.5rem;
    }
    .card {
      margin-bottom: 0.5rem;
    }
    .back {
      .link {
        &-bottom {
          transform: rotateZ(-90deg) scale(0.6);
        }
      }
    }
    .software {
      &-title {
        text-align: right;
        font-size: 1.5rem;
        margin-top: 2rem;
      }
    }
  }
}
@media (min-width: 992px) {
  .container-fluid {
    .back {
      .link {
        &-bottom {
          transform: rotateZ(-90deg) scale(0.8);
        }
      }
    }
    .skill {
      &-description {
        align-items: center;
        width: 90%;
        margin: auto;
        padding-top: 5rem;
      }
    }
    .btn {
      font-size: 1rem;
    }
    .software {
      &-title {
        text-align: right;
      }
    }
  }
}
</style>
