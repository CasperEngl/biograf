const spacing = {
  1: '0.25rem',
  '-1': '-0.25rem',
  2: '0.5rem',
  '-2': '-0.5rem',
  3: '0.75rem',
  '-3': '-0.75rem',
  4: '1rem',
  '-4': '-1rem',
  5: '1.25rem',
  '-5': '-1.25rem',
  6: '1.5rem',
  '-6': '-1.5rem',
  7: '1.75rem',
  '-7': '-1.75rem',
  8: '2rem',
  '-8': '-2rem',
  10: '2.5rem',
  '-10': '-2.5rem',
  11: '2.75rem',
  '-11': '-2.75rem',
  12: '3rem',
  '-12': '-3rem',
  14: '3.5rem',
  '-14': '-3.5rem',
  16: '4rem',
  '-16': '-4rem',
  18: '4.5rem',
  '-18': '-4.5rem',
  20: '5rem',
  '-20': '-5rem',
  22: '5.5rem',
  '-22': '-5.5rem',
  24: '6rem',
  '-24': '-6rem',
  25: '6.25rem',
  '-25': '-6.25rem',
  26: '6.5rem',
  '-26': '-6.5rem',
  28: '7rem',
  '-28': '-7rem',
  30: '7.5rem',
  '-30': '-7.5rem',
  32: '8rem',
  '-32': '-8rem',
  36: '9rem',
  '-36': '-9rem',
  40: '10rem',
  '-40': '-10rem',
  44: '11rem',
  '-44': '-11rem',
  48: '12rem',
  '-48': '-12rem',
  52: '13rem',
  '-52': '-13rem',
  56: '14rem',
  '-56': '-14rem',
  60: '15rem',
  '-60': '-15rem',
  64: '16rem',
  '-64': '-16rem',
  66: '16.5rem',
  '-66': '-16.5rem',
  72: '18rem',
  '-72': '-18rem',
  80: '20rem',
  '-80': '-20rem',
  88: '22rem',
  '-88': '-22rem',
  96: '24rem',
  '-96': '-24rem',
  xs: '20rem',
  sm: '24rem',
  md: '28rem',
  lg: '32rem',
  xl: '36rem',
  '2xl': '42rem',
  '3xl': '48rem',
  '4xl': '56rem',
  '5xl': '64rem',
  '6xl': '72rem',
  '8xl': '96rem',
  '10xl': '120rem',
};

module.exports = {
  theme: {
    container: {
      center: true,
      padding: '1rem',
    },
    aspectRatio: { // defaults to {}
      square: [1, 1],
      '16/9': [16, 9],
      '4/3': [4, 3],
      '21/9': [21, 9],
      '9/16': [9, 16],
    },
    filter: {
      none: 'none',
      grayscale: 'grayscale(1)',
      invert: 'invert(1)',
      sepia: 'sepia(1)',
    },
    backdropFilter: {
      none: 'none',
      'blur-5': 'blur(5px)',
      'blur-10': 'blur(10px)',
      'blur-15': 'blur(15px)',
      'blur-20': 'blur(20px)',
      'blur-25': 'blur(25px)',
      'blur-30': 'blur(30px)',
    },
    boxShadow: {
      default: '0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .15)',
      md: ' 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .15)',
      lg: ' 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .15)',
      xl: ' 0 20px 25px -5px rgba(0, 0, 0, .1), 0 10px 10px -5px rgba(0, 0, 0, .15)',
      '2xl': '0 25px 50px -12px rgba(0, 0, 0, .25)',
      '3xl': '0 35px 60px -15px rgba(0, 0, 0, .3)',
      inner: 'inset 0 2px 4px 0 rgba(0,0,0,0.15)',
      outline: '0 0 0 3px rgba(66,153,225,0.5)',
      focus: '0 0 0 3px rgba(66,153,225,0.5)',
      none: 'none',
    },
    extend: {
      negativeMargin: spacing,
      margin: spacing,
      padding: spacing,
      width: {
        row: 'calc(100% + 1.5rem)',
        'row-tight': 'calc(100% + 0.5rem)',
      },
      maxWidth: spacing,
      minWidth: spacing,
      maxHeight: spacing,
      minHeight: spacing,
    },
  },
  variants: {
    aspectRatio: ['responsive'],
    opacity: ['group-hover'],
    textColor: ['responsive', 'hover', 'focus', 'visited', 'group-hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
  },
  plugins: [
    require('tailwindcss-aspect-ratio')(),
    require('tailwindcss-transitions')(),
    require('tailwindcss-filters')(),
    require('tailwindcss-alpha')({
      modules: {
        colors: true,
      },
      alpha: {
        0: 0,
        10: 0.1,
        20: 0.2,
        30: 0.3,
        40: 0.4,
        50: 0.5,
        60: 0.6,
        70: 0.7,
        80: 0.8,
        90: 0.9,
        100: 1,
      },
    }),
  ],
};
