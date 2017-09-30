return {
                content: [
                    getOfferLogo(), //Get the logo or empty string
                    getHeading(), //get the customer and business data (adress etc)
                    //the above is always the same
                    getText(), //get the textblock, created by user and always different
                    getSpecifics(), //get a table of payment specifications
                    getSignature() //get last textblock contaning signature fields etc, always the same
                ],
                styles: {
                    subheader: {
                        fontSize: 15,
                        bold: true,
                        alignment: 'center'
                    }
                },
                defaultStyle: {
                    columnGap: 20,
                    fontSize: 12
                }
            };


// In the DocDefinition you can add a function for pageBreakBefore like this:

content: [{
    text: getOfferClosingParagraph(),
    id: 'closingParagraph'
  }, {
    text: getSignature(),
    id: 'signature'
  }],
  pageBreakBefore: function(currentNode, followingNodesOnPage, nodesOnNextPage, previousNodesOnPage) {
    //check if signature part is completely on the last page, add pagebreak if not
    if (currentNode.id === 'signature' && (currentNode.pageNumbers.length != 1 || currentNode.pageNumbers[0] != currentNode.pages)) {
      return true;
    }
    //check if last paragraph is entirely on a single page, add pagebreak if not
    else if (currentNode.id === 'closingParagraph' && currentNode.pageNumbers.length != 1) {
      return true;
    }
    return false;
  },