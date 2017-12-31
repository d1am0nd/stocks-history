export const li = function(bgColor, textColor = null) {
  return {
    'width': '100%',
    'fontSize': '20px',
    'background': bgColor,
    'color': textColor ? textColor : 'black',
  };
};

export const ul = function() {
  return {
    'listStyleType': 'none',
    'padding': 0,
    'margin': 0,
  };
};
