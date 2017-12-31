import React from 'react';
import radium from 'radium';

import {fetchStocks, fetchMonths} from './api/stock';
import Graph from './components/graphs/Graph';

import {
  wrapper as wrapperStyle,
} from './styles/layout';

@radium()
class Main extends React.Component {
  constructor() {
    super();
    this.state = {stocks: [], data: [], selected: {}};

    fetchStocks()
      .then(res => {
        const newState = {
          stocks: res.data,
          selected: typeof res.data[0] !== 'undefined' ?
            res.data[1] : {},
        };
        this.setState(newState);
        this.fetchStockMonths(newState.selected.symbol);
      })
      .catch(err => {
        console.log(err);
      });
  }

  fetchStockMonths(symbol) {
    return new Promise((resolve, reject) => {
      fetchMonths(symbol)
      .then(res => {
        this.setState({
          data: res.data.months,
        });
        resolve(res);
      })
      .catch(err => {
        console.log(err);
        reject(err);
      });
    });
  }

  handleStockChange(e) {
    const newSymbol = e.target.value;
    this.setState({
      selected: this.state.stocks.find(s => {
        return s.symbol === newSymbol;
      }),
    });
    console.log(this.state.selected);
    this.fetchStockMonths(newSymbol);
  }

  render() {
    return (
      <div style={wrapperStyle()}>
        <Graph data={this.state.data}/>
        <select
          onChange={e => this.handleStockChange(e)}
          value={this.state.selected.symbol}>
          {this.state.stocks.map((s, i) => {
            return (
              <option
                key={`stock-opt-${i}`}
                value={s.symbol}>
                {s.name} ({s.symbol.toUpperCase()})
              </option>
            );
          })}
        </select>
      </div>
    );
  }
}

export default Main;
