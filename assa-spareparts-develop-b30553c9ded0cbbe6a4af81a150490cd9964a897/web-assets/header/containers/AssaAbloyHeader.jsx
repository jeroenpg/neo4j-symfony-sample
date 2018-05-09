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
 * Created at: 03/01/2018
 * Created by: jeroen
 */

import React from 'react';
import { AssaAbloyLogo } from '../components/AssaAbloyLogo';
import { Link } from 'react-router-dom';

export class AssaAbloyHeader extends React.Component {

  render() {
    return <div style={{ padding: 5, borderBottom: "4px solid #0096ca", marginBottom: 5, height: 45}}>
      <Link style={{float: "left" }} to={ "/" }>
        <AssaAbloyLogo />
      </Link>
      {
        this.props.back &&
          <a onClick={() => {this.props.back() }}>
            <span style={{ fontSize: 20, float: "right", cursor: "pointer" }}>Go back</span>
          </a>
      }
    </div>
  }
}