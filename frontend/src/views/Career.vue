<template>
  <b-container fluid>
    <Header title="Parcours" color="#00a1ba" class="header" />
    <CircleBackground circleColor="#00a1ba"/>
    <Transition v-show="showTransition" directionAnimation="down" colorSlideOne="#00a1ba"/>
    <CareerStage
      v-for="(careerStage, index) in allCareerStages.slice().reverse()"
      :key="careerStage.id"
      :title="careerStage.name"
      :description="careerStage.description"
      :company="careerStage.company"
      :logo="careerStage.logoCompany"
      :startDate="careerStage.startDate"
      :endDate="careerStage.endDate"
      color="#00a1ba"
      :parity="index % 2 ? (parity = 'even') : (parity = 'odd')"
    />
    <b-row class="footer justify-content-center align-items-center mt-3 mb-5">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowRtl"
        class="link link-bottom"
        textColor="#00a1ba"
        hoverColor="#00a1ba"
      />
    </b-row>
    <div class="line"></div>
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import Header from "@/components/Header.vue";
import CareerStage from "@/components/CareerStage.vue";
import Transition from "@/components/Transition.vue";
import CircleBackground from "@/components/CircleBackground.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    HomePageLink,
    Header,
    CareerStage,
    Transition,
    CircleBackground
  },
  data() {
    return {
      showTransition: true
    };
  },
  methods: {
    // Start transition effect and hide it after 1.3s
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    ...mapActions(["getAllCareerStage"])
  },
  computed: {
    ...mapGetters(["allCareerStages"])
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  //Dispatch all career stage contains in career vuex module
  mounted() {
    this.$store.dispatch("getAllCareerStage");
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
  min-height: 100vh;
  overflow: hidden;
}
.footer {
  height: 15vh;
}
.line {
  position: absolute;
  height: 70%;
  width: 3px;
  left: 50%;
  top: 14%;
  margin: 0.2rem;
  background-color: $white;
  transform: translateZ(-10px);
  animation: scale-up-ver-top 2s cubic-bezier(0.39, 0.575, 0.565, 1) 0.5s both;
  z-index: -1;
}
@keyframes scale-up-ver-top {
  0% {
    transform: scaleY(0);
    transform-origin: 100% 0%;
    background-color: $light-blue;
  }
  100% {
    transform: scaleY(1);
    transform-origin: 100% 0%;
    background-color: $white;
  }
}
@media (min-width: 320px) {
  .container-fluid {
    .line {
      display: none;
    }
    .link {
      transform: rotate(90deg) scale(0.6);
    }
  }
}
@media (min-width: 768px) {
  .container-fluid {
    .line {
      display: initial;
      height: 82%;
      top: 10%;
    }
    .link {
      transform: rotate(90deg) scale(0.6);
    }
  }
}
@media (min-width: 992px) {
  .container-fluid {
    .line {
      display: initial;
      height: 78%;
      top: 12%;
    }
  }
}
@media (min-width: 1200px) {
  .container-fluid {
    .line {
      display: initial;
      height: 77%;
      top: 12%;
    }
  }
}
</style>
