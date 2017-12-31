import {
  primaryColor,
  secondaryColor,
} from '../vars';
import {
  simple as simpleBorder,
} from '../reusable/border';

export const simpleWrapper = () => {
  return {
    ...simpleBorder(),
    'backgroundColor': 'white',
  };
};

export const simpleUl = () => {
  return {
    'listDecoration': 'none',
    'listStyleType': 'none',
    'padding': 0,
  };
};

export const date = () => {
  return {

  };
};

export const primary = () => {
  return {
    'color': primaryColor,
  };
};

export const secondary = () => {
  return {
    'color': secondaryColor,
  };
};
