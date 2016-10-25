// ------------------------------------------------------------------------
// eca-sample-conversion.h: Routines for convering between sample formats.
// Copyright (C) 2002,2003 Kai Vehmanen
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  USA
// ------------------------------------------------------------------------

#ifndef INCLUDED_ECA_SAMPLE_CONVERSION_H
#define INCLUDED_ECA_SAMPLE_CONVERSION_H

#include <kvu_inttypes.h>

/**
 * Type definitions
 */

#ifndef INT8_MAX
#define INT8_MAX (127)
#endif

#ifndef UINT8_MIN
#define UINT8_MIN (0)
#endif

#ifndef UINT8_MAX
#define UINT8_MAX (255U)
#endif

#ifndef INT16_MAX
#define INT16_MAX (32767)
#endif

#ifndef INT16_MIN
#define INT16_MIN (-32767-1)
#endif

#ifndef INT32_MAX
#define INT32_MAX (2147483647)
#endif

#ifndef INT32_MIN
#define INT32_MIN (-2147483647-1)
#endif

/**
 * Function definitions
 */

static inline uint8_t eca_sample_convert_float_to_u8(float inval)
{
  const float pos_limit = ((float)0x7f) / 0x80;
  if (inval >= pos_limit)
    return UINT8_MAX;

  return (uint8_t)(inval * 0x80 + 0x80);
}

static inline int16_t eca_sample_convert_float_to_s16(float inval)
{
  const float pos_limit = ((float)0x7fff) / 0x8000;
  if (inval >= pos_limit)
    return INT16_MAX;

  return (int16_t)(inval * 0x8000);
}

static inline int32_t eca_sample_convert_float_to_s32(float inval)
{
  /* 32bit float precision is limited to 24bit */
  const float pos_limit_24b = ((float)0x7fffff) / 0x800000;
  if (inval >= pos_limit_24b)
    return INT32_MAX;

  return (int32_t)(inval * 0x80000000);
}

static inline float eca_sample_convert_u8_to_float(uint8_t inval)
{
#if 0
  /* NOTE: this is sub-optimal, but at least gcc-2.91.66 otherwise
   *       compiles the test incorrectly) */
  int16_t inval_b = inval;
  if (inval_b <= INT8_MAX)
    return(((((float)inval) - INT8_MAX) / INT8_MAX));
#endif

  return ((float)(inval - 0x80)) / 0x80;
}

static inline float eca_sample_convert_s16_to_float(int16_t inval)
{
  return ((float)inval) / 0x8000;
}

static inline float eca_sample_convert_s32_to_float(int32_t inval)
{
  return ((float)inval) / 0x80000000;
}

#endif
