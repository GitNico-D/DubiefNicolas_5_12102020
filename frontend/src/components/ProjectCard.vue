<template>
  <div class="cardflip mb-3">
    <b-card
      overlay
      :img-src="imgSrc"
      :img-alt="imgAlt"
      :date="date"
      class="frontcard"
    >
    </b-card>
    <b-card class="backcard">
      <b-card-text>
        <p class="card-title text-center">{{ title }}</p>
        <p class="card-text-content">{{ content }}</p>
      </b-card-text>
      <b-link :href="url" class="btn">Vers le site</b-link>
    </b-card>
  </div>
</template>

<script>
import formatDate from "../services/formatDate";

export default {
  name: "Project",
  props: {
    title: String,
    content: String,
    color: String,
    url: String,
    imgSrc: String,
    imgAlt: String,
    date: String
  },
  methods: {
    formatDate(date){
      return formatDate(date)
    }
  },
};
</script>

<style lang="scss">
.cardflip {
  font-family: "Oswald", sans-serif;
  .frontcard,
  .backcard {
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transition-duration: 1s;
    transition-property: transform, opacity;
    color: white;
    padding: 0.5em;
    background: $white;
    border-radius: 10px;
    .card {
      &-title {
        font-size: 3rem;
      }
    }
  }
  .frontcard {
    transform: rotateY(0deg);
    @include box_shadow(0px, 0px, 5px, $white);
    background: $white;
    .card {
      &-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
    }
  }
  .backcard {
    position: absolute;
    opacity: 0;
    top: 0px;
    left: 0px;
    width: inherit;
    height: 100%;
    transform: rotateY(-180deg);
    @include box_shadow(0px, 0px, 30px, $purple);
    @include box_shadow(0px, 0px, 1px, $purple);
    .card {
      &-text {
        padding: 0.5rem;
        font-size: 1.1rem;
        line-height: 2rem;
        color: $purple;
        border-radius: 10px;
        text-align: center;
        font-family: "Oswald", sans-serif;
      }
      &-body {
        display: flex;
        flex-direction: column;
        .btn {
          color: $purple !important;
          background-color: transparent !important;
          border: 1px solid $purple !important;
          transform: translateZ(100px);
          &:hover {
            color: $white !important;
            background-color: $purple !important;
            @include box_shadow(0px, 0px, 10px, $purple);
          }
        }
      }
      &-title {
        font-family: "Montserrat", sans-serif;
        color: $purple;
        text-transform: uppercase;
        @include special-text-shadow;
        margin-bottom: 1.5rem;
      }
    }
  }
  &:hover {
    .frontcard {
      transform: rotateY(180deg);
    }
    .backcard {
      opacity: 1;
      transform: rotateY(0deg);
    }
  }
}

@media (min-width: 320px) {
  .cardflip {
    width: 100%;
    margin: 1rem;
    .backcard {
      .card {
        &-body {
          padding: unset;
          justify-content: center;
        }
        &-text {
          padding: unset;
          font-size: 0.6rem;
          line-height: unset;
          &-date {
            margin-bottom: 0.25rem;
          }
          &-content {
            margin-bottom: 0;
          }
        }
        &-title {
          font-size: 0.6rem;
        }
      }
      .btn {
        font-size: 0.5rem;
      }
    }
  }
}
@media (min-width: 576px) {
  .cardflip {
    .backcard {
      .card {
        &-body {
          padding: 1.25rem;
        }
        &-text {
          padding: 0.6rem;
          font-size: 1rem;
          line-height: 2rem;
        }
        &-title {
          font-size: 1rem;
        }
      }
    }
  }
}
@media (min-width: 768px) {
  .cardflip {
    width: 40rem;
    .backcard {
      .card {
        &-body {
          justify-content: space-around;
        }
        &-text {
          padding: 0.8rem;
          font-size: 1.2rem;
          line-height: 2.1rem;
          &-content {
            margin: 0;
          }
        }
        &-title {
        font-size: 2rem;
        }
      }
      .btn {
        font-size: 1rem;
      }
    }
  }
}
</style>
