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
class Tooltip extends React.Component {
  prettyDate() {
    if (!this.props.data.date) {
      return '';
    }
    return this.props.data.date.substring(0, 10);
  }
  render() {
    return (
      <div style={wrapperStyle()}>
        <ul style={ulStyle()}>
          <li style={dateStyle()}>
            Date: {this.prettyDate()}
          </li>
          <li style={primaryStyle()}>
            Close: {this.props.data.close}
          </li>
          <li style={secondaryStyle()}>
            Volume: {this.props.data.volume}
          </li>
          <li>
            High: {this.props.data.high}
          </li>
          <li>
            Low: {this.props.data.low}
          </li>
        </ul>
      </div>
    );
  }
}

export default Tooltip;
