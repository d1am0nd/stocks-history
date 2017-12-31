import React from 'react';
import radium from 'radium';

import {
  simpleWrapper as wrapperStyle,
  simpleUl as ulStyle,
  date as dateStyle,
  primary as primaryStyle,
  secondary as secondaryStyle,
} from '../../../styles/graph/tooltip';

@radium()
class Simple extends React.Component {
  render() {
    const {x, y, stroke, value} = this.props;

    return <text
      x={x}
      y={y}
      dy={-4}
      fill={stroke}
      fontSize={10}
      textAnchor="middle">
      {value}
    </text>;
  }
}

export default Simple;
