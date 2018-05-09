/**
 *         _             __        __ _
 *   /\/\ (_) ___ __ _  / _\ ___  / _| |___      ____ _ _ __ ___
 *  /    \| |/ __/ _` | \ \ / _ \| |_| __\ \ /\ / / _` | '__/ _ \
 * / /\/\ \ | (_| (_| | _\ \ (_) |  _| |_ \ V  V / (_| | | |  __/
 * \/    \/_|\___\__,_| \__/\___/|_|  \__| \_/\_/ \__,_|_|  \___|
 * ----------------------------------------------
 * Copyright (c) 2017, Mica Software
 * All rights reserved.
 * ----------------------------------------------
 *
 * Created at: 11/12/2017
 * Created by: jeroen
 */

import React from 'react';
import PropTypes from 'prop-types'; // ES6
import ImageZoom from 'react-medium-image-zoom'

export class Part extends React.Component {
    static propTypes = {
      part: PropTypes.object
    };

    render() {
        const { id, name, description, image } = this.props.part;
        const imageSrc = image ? require('../../image/part/' + image) : require('../../image/no_category.png');

        return <div className={'part'} style={{padding: 10, borderColor: '#0096ca', borderWidth: 1, borderStyle: "solid", width: 200}}>
            <a onClick={(event) => { event.preventDefault() }}>
              <ImageZoom
                image={{
                  src: imageSrc,
                  className: 'img',
                  style: { width: '100%' }
                }}
                zoomImage={{
                  src: imageSrc
                }}
              />
            </a>
            <div style={{ fontSize: 16, marginBottom: 5 }}>{ name }</div>
            <div>{ description.substring(0, 90) }{description.length > 90 && "..."}</div>
        </div>
    }
}
