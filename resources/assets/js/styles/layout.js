import {
  center,
} from './common';
import {
  baseWidthN,
} from './vars';

export const baseWidth = () => {
  return {
    'width': `${baseWidthN}px`,
    'maxWidth': '100%',
  };
};

export const wrapper = () => {
  return {
    ...baseWidth(),
    ...center(),
  };
};
