import React from 'react';
import radium from 'radium';

import {
  primaryColor,
  secondaryColor,
} from '../../../styles/vars';
import {
  li as liSyle,
  ul as ulStyle,
} from '../../../styles/graph/legend';

@radium()
class Simple extends React.Component {
  render() {
    return (
      <div>
        <ul style={ulStyle()}>
          <li style={liSyle(primaryColor)}>
            Close
          </li>
          <li style={liSyle(secondaryColor)}>
            Vol
          </li>
        </ul>
      </div>
    );
  }
}

export default Simple;
