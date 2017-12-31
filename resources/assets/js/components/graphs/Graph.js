import React from 'react';
import radium from 'radium';

import {
  baseWidthN,
  primaryColor,
  secondaryColor,
} from '../../styles/vars';
import {
  graphWrapper as graphWrapperStyle,
} from '../../styles/graph/layout';

import CustomTooltip from './Tooltip/Simple';
import CustomLabel from './Label/Simple';
import Legend from './Legends/Simple';
import {
  LineChart,
  Line,
  Tooltip,
  CartesianGrid,
  XAxis,
  YAxis,
} from 'recharts';
import {
  full as fullMonth,
} from '../../date/months';

function extractData(comp) {
  if (typeof comp === 'undefined' ||
    comp.payload === null ||
    typeof comp.payload === 'undefined' ||
    typeof comp.payload[0] === 'undefined') {
    return {};
  }
  return comp.payload[0].payload;
}

@radium()
class Graph extends React.Component {
  constructor() {
    super();
    this.state = {
      height: window.innerHeight,
      width: window.innerWidth,
    };
  }

  updateDimensions() {
    this.setState({
      height: window.innerHeight > 400 ? 400 : window.innerHeight,
      width: window.innerWidth > baseWidthN ? baseWidthN : window.innerWidth,
    });
  }

  componentWillMount() {
    this.updateDimensions();
  }

  componentDidMount() {
    window.addEventListener('resize', this.updateDimensions.bind(this));
  }

  componentWillUnmount() {
    window.removeEventListener('resize', this.updateDimensions.bind(this));
  }

  handleLineClick(comp) {
    const date = new Date(comp.activePayload[0].payload.date);
    const searchTerm = `${fullMonth(date.getMonth())} ` +
      `${date.getFullYear()} ` +
      `${this.props.stock.name} `;

    window.open(`https://www.google.com/search?q=${searchTerm}`, '_blank');
  }

  transformedData() {
    if (this.props.data.length < 1) {
      return [];
    }
    const k = (this.props.data.reduce((r, i) => {
      return Math.max(r, i.close);
    }, 0) / this.props.data.reduce((r, i) => {
      return Math.max(r, i.volume);
    }, 0));
    return this.props.data.map(i => {
      const date = new Date(i.date);
      const shortY = date.getFullYear().toString().charAt(2) +
        date.getFullYear().toString().charAt(3);
      const pretty = `${date.getMonth()}-'${shortY}`;
      return {
        ...i,
        adjustedVolume: i.volume * k,
        prettyDate: pretty,
      };
    });
  }

  render() {
    return (
      <div>
        <Legend/>
        <div style={graphWrapperStyle()}>
          <LineChart
            width={this.state.width}
            height={this.state.height}
            onClick={(a, b, c) => this.handleLineClick(a, b, c)}
            data={this.transformedData()}>
            <Line
              isAnimationActive={this.props.animate}
              type={`monotone`}
              label={`close`}
              dataKey={`close`}
              stroke={primaryColor} />
            <Line
              isAnimationActive={this.props.animate}
              type={`monotone`}
              label={`adjustedVolume`}
              dataKey={`adjustedVolume`}
              strokeDasharray="5 5"
              stroke={secondaryColor} />
            <CartesianGrid stroke="#ccc" />
            <Tooltip
              content={i => {
                return (
                  <CustomTooltip data={extractData(i)}/>
                );
              }}/>
            <XAxis
              interval={`preserveStartEnd`}
              dataKey={`prettyDate`}/>
            <YAxis />
          </LineChart>
        </div>
      </div>
    );
  }
}

export default Graph;
